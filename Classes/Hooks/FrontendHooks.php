<?php
namespace Webenergy\MhHttpbl\Hooks;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Charset\CharsetConverter;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class FrontendHooks
 *
 * @author Marc Hoersken <info@marc-hoersken.de>
 * @author Jigal van Hemert <jigal@xs4all.nl>
 * @author Julian Hofmann <julian.hofmann@webenergy.de>
 */
class FrontendHooks
{
    /**
     * @var string
     */
    private $extKey = 'mh_httpbl';

    /**
     * @var bool
     */
    private $debug = false;

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var TypoScriptFrontendController
     */
    private $pObj;

    /**
     * @var array
     */
    private $config = [];

    /**
     * @var string
     */
    private $domain = 'dnsbl.httpbl.org';

    /**
     * @var string
     */
    private $content = '';

    /**
     * @var string
     */
    private $request = '';

    /**
     * @var string
     */
    private $result = '';

    /**
     * @var int
     */
    private $first = 0;

    /**
     * @var int
     */
    private $days = 0;

    /**
     * @var int
     */
    private $score = 0;

    /**
     * @var int
     */
    private $type = -1;

    /**
     * @var array
     */
    private $codes = [
        0 => 'Search Engine',
        1 => 'Suspicious',
        2 => 'Harvester',
        3 => 'Suspicious &amp; Harvester',
        4 => 'Comment Spammer',
        5 => 'Suspicious &amp; Comment Spammer',
        6 => 'Harvester &amp; Comment Spammer',
        7 => 'Suspicious &amp; Harvester &amp; Comment Spammer'
    ];

    /**
     * Hook page id lookup before rendering the content.
     *
     * @param array $params parameter array
     * @param TypoScriptFrontendController $pObj partent object
     */
    public function checkBlacklist(&$params, &$pObj)
    {
        $this->params = &$params;
        $this->pObj = &$pObj;
        $this->config = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
        $this->debug = $this->config['debug'];
        $this->type = $this->runQuery();

        if (($this->type >= $this->config['type']) && (($this->score >= $this->config['score']) || (empty($this->config['score'])))) {
            $this->stopOutput();
        } else {
            $this->pObj->fe_user->setKey('ses', 'tx_mhhttpbl_user', true);
            $this->pObj->fe_user->storeSessionData();
        }
    }

    /**
     * Sends a DNS request to dnsbl.httpbl.org and checks for bad users.
     *
     * @return int IP type
     */
    private function runQuery()
    {
        if ($this->debug) {
            GeneralUtility::devlog('accesskey: ' . $this->config['accesskey'], $this->extKey, 1);
        }

        if (empty($this->config['accesskey'])) {
            return -1;
        }

        if (empty($_SERVER['REMOTE_ADDR'])) {
            return -2;
        }

        $remote_addr = $_SERVER['REMOTE_ADDR'];

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_mhhttpbl_whitelist');

        $whitelistedEntry = $queryBuilder
            ->select('uid')
            ->from('tx_mhhttpbl_whitelist')
            ->where(
                $queryBuilder->expr()->eq('whitelist_ip', $queryBuilder->createNamedParameter($remote_addr))
            )
            ->setMaxResults(1)
            ->execute()
            ->fetch();

        if ($whitelistedEntry) {
            return -3;
        }

        if (
            $this->pObj->fe_user->getKey('ses', 'tx_mhhttpbl_user') == true
            || (($this->pObj->fe_user->getKey('ses', 'tx_mhhttpbl_hash') == GeneralUtility::_GET('continue')) && (strlen(GeneralUtility::_GET('continue')) > 0))
        ) {
            return -4;
        }

        $this->request = $this->config['accesskey'] . '.' . implode('.', array_reverse(explode('.', $_SERVER['REMOTE_ADDR']))) . '.' . $this->domain;
        $this->result = gethostbyname($this->request);

        if ($this->result != $this->request) {
            list($this->first, $this->days, $this->score, $this->type) = explode('.', $this->result);
        }

        if ($this->debug) {
            GeneralUtility::devlog('dnsbl.httpbl.org result: ' . $this->result, $this->extKey, 1);
        }

        if ($this->first != 127 || !array_key_exists($this->type, $this->codes)) {
            return -5;
        }

        return $this->type;
    }

    /**
     * Stops TYPO3 output and shows an error page.
     */
    private function stopOutput()
    {
        if ($this->debug) {
            GeneralUtility::devlog('blocking user: ' . $_SERVER['REMOTE_ADDR'], $this->extKey, 1);
        }

        $remote_addr = $_SERVER['REMOTE_ADDR'];
        $remote_host = gethostbyaddr($remote_addr);
        $remote_addr_html = htmlspecialchars($remote_addr);
        $remote_host_html = htmlspecialchars($remote_host);

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_mhhttpbl_blocklog');
        $queryBuilder
            ->insert('tx_mhhttpbl_blocklog')
            ->values(
                [
                    'crdate' => $GLOBALS['SIM_ACCESS_TIME'],
                    'tstamp' => $GLOBALS['SIM_ACCESS_TIME'],
                    'block_ip' => $remote_addr,
                    'block_type' => $this->type,
                    'block_score' => $this->score
                ]
            )
            ->execute();
        //$GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_mhhttpbl_blocklog', ['crdate'=>time(), 'tstamp'=>time(), 'block_ip'=>$remote_addr, 'block_type'=>$this->type, 'block_score'=>$this->score]);

        $charsetConverter = GeneralUtility::makeInstance(CharsetConverter::class);
        $usrHash = GeneralUtility::shortMD5(serialize($_SERVER));
        $stdMsg = '<strong>You have been blocked.</strong><br />Your IP appears to be on the httpbl.org/projecthoneypot.org blacklist.<br /><br />###REQUEST_IP###<br /><br />###USER_TYPE###';
        $message = (empty($this->config['message']) ? $stdMsg : $charsetConverter->utf8_encode($this->config['message'], 'utf-8'));
        $message = str_replace('###REQUEST_IP###', '<strong>' . $remote_addr_html . '</strong> (' . $remote_host_html . ')', $message);
        $message = str_replace('###USER_TYPE###', $this->codes[$this->type], $message);

        $this->pObj->fe_user->setKey('ses', 'tx_mhhttpbl_hash', $usrHash);
        $this->pObj->fe_user->setKey('ses', 'tx_mhhttpbl_user', false);
        $this->pObj->fe_user->storeSessionData();

        $content = '
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>TYPO3 - http:BL</title>
	</head>
	<body style="background: #fff; color: #ccc; font-family: \'Verdana\', \'Arial\', sans-serif; text-align: center;">
		' . $message . '
	</body>
	<script type="text/javascript">
		window.location.replace(window.location.href.split(\'?\')[0] + \'?continue=' . $usrHash . '\');
	</script>
</html>
		';

        // A Former version of this extension tried to set the output to a class variable which is used
        // later by the second hook-method ( addHoneyPot() ). Could not get this working in TYPO3 8.7.
        //$this->content = $content;
        echo $content;
        HttpUtility::setResponseCodeAndExit(HttpUtility::HTTP_STATUS_403);
        die;
    }

    /**
     * Hook content before caching.
     *
     * @param array $params parameter array
     * @param  TypoScriptFrontendController $pObj partent object
     */
    public function addHoneyPot(&$params, &$pObj)
    {
        $this->params = &$params;
        $this->pObj = &$pObj;
        $this->config = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);

        if (!empty($this->config['quicklink'])) {
            $imgConfig = [
                'file' => 'EXT:mh_httpbl/Resources/Public/Images/clear.gif',
                'file.' => [
                    'maxH' => 1,
                    'maxW' => 1
                ],
                'stdWrap.' => [
                    'typolink.' => [
                        'parameter' => $this->config['quicklink'],
                        'title' => '',
                        'wrap' => '<div style="display: none;">|</div>',
                    ]
                ]
            ];
            /*
                Create file with clear.gif
                Wrap it with a link to the Quicklink
                Wrap it in a div to comply with XHTML 1.0 Strict
            */
            /** @var ContentObjectRenderer $cObj */
            $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
            $cObj->start([], 'tt_content');
            // Create a cObj to do the work of generating (X)HTML
            if (file_exists(ExtensionManagementUtility::extPath('mh_httpbl') . 'Resources/Public/Images/clear.gif')) {
                $content = $cObj->cObjGetSingle('IMAGE', $imgConfig);
            } else {
                $content = $cObj->typoLink('<!-- &nbsp; -->', $imgConfig['stdWrap.']['typolink.']);
                // If no clear.gif is found use a part of the configuration to wrap a link and div around a comment...
            }
        }

        if (!empty($this->content)) {
            $pObj->content = trim($this->content);
            $pObj->no_cache = true;
        } else {
            if (!empty($this->config['quicklink'])) {
                $pObj->content = str_replace('</body>', $content . '</body>', $this->pObj->content);
            }
        }
    }
}
