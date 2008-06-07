<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Marc Hoersken <info@marc-hoersken.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * class 'tx_mhhttpbl' for the 'mh_httpbl' extension.
 *
 */

/**
 * http:BL blocking extension
 *
 * @author	Marc Hoersken <info@marc-hoersken.de>
 * @package TYPO3
 * @subpackage mh_httpbl
 */
class tx_mhhttpbl {
	var $extKey = 'mh_httpbl';
	var $debug = false;
	var $params = false;
	var $pObj = false;
	var $config = false;
	var $domain	= 'dnsbl.httpbl.org';
	var $type = -1;
	var $codes = array(
		0 => 'Search Engine',
		1 => 'Suspicious',
		2 => 'Harvester',
		3 => 'Suspicious &amp; Harvester',
		4 => 'Comment Spammer',
		5 => 'Suspicious &amp; Comment Spammer',
		6 => 'Harvester &amp; Comment Spammer',
		7 => 'Suspicious &amp; Harvester &amp; Comment Spammer'
	);

	/**
	 * Determines if content should be outputted.
	 * Outputting content is done only if jumpUrl is NOT set.
	 *
	 * @param	object		$_params: parameter array
	 * @param	object		$pObj: partent object
	 * @return	void
	 */
	function checkBlacklist (&$params, &$pObj) {
		$this->params = &$params;
		$this->pObj = &$pObj;
		$this->config = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
		if ($this->config['debug']) {
			$this->debug = true;
		}
		if ($this->runQuery() >= $this->config['type']) {
			$this->stopOutput();
		}
	}
	
	/**
	 * Sends a DNS request to dnsbl.httpbl.org and checks for bad users.
	 *
	 * @return	integer		IP type
	 */
	function runQuery() {
		if ($this->debug)
			t3lib_div::devlog('accesskey: ' . $this->config['accesskey'], $this->extKey, 1);
		
		if (empty($this->config['accesskey']))
			return $this->type = -1;
		
		if (empty($_SERVER['REMOTE_ADDR']))
			return $this->type = -1;
		
		$result = gethostbyname($this->config['accesskey'].implode('.', array_reverse(explode('.', $_SERVER['REMOTE_ADDR']))).$this->domain);
		list($first, $days, $score, $type) = explode('.', $result);
		
		if ($this->debug)
			t3lib_div::devlog('dnsbl.httpbl.org result: ' . $result, $this->extKey, 1);
		
		if($first == 127)
			return $this->type = $type;
		else
			return $this->type = -1;
	}

	/**
	 * Stops TYPO3 output and shows an error page.
	 *
	 * @return	void
	 */
	function stopOutput () {
		if ($this->debug)
			t3lib_div::devlog('blocking user: ' . $_SERVER['REMOTE_ADDR'], $this->extKey, 1);
		
		$stdMsg = '<strong>You have been blocked.</strong><br />
		Your IP appears to be on the httpbl.org/projecthoneypot.org blacklist.<br />
		<br />
		###REQUEST_IP###<br />
		<br />
		###USER_TYPE###';

		$message = $this->config['message'];
		if (strcmp('', $message)) {
			$message = $this->pObj->csConvObj->utf8_encode($message,$this->pObj->renderCharset);	// This page is always encoded as UTF-8
		} else $message = $stdMsg;
		$request_ip = '<strong>' . $_SERVER['REMOTE_ADDR'] . '</strong> (' . gethostbyaddr($_SERVER['REMOTE_ADDR']) . ')';
		$message = str_replace('###REQUEST_IP###', $request_ip, $message);
		$message = str_replace('###USER_TYPE###', $this->codes[$this->type], $message);

		$temp_content = '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>TYPO3 - http:BL</title>
	</head>
	<body style="background-color:white; font-family:Verdana,Arial,Helvetica,sans-serif; color:#cccccc; text-align:center;">
		'.$message.'
	</body>
</html>';

		die($temp_content); // maybe there is a better way in TYPO3?
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mh_httpbl/class.tx_mhhttpbl.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mh_httpbl/class.tx_mhhttpbl.php']);
}
?>