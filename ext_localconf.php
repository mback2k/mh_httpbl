<?php
if(!defined('TYPO3_MODE'))   die('Access denied.');

require_once(t3lib_extMgm::extPath($_EXTKEY).'class.tx_mhhttpbl.php');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['isOutputting'][] = 'EXT:mh_httpbl/class.tx_mhhttpbl.php:&tx_mhhttpbl->checkBlacklist';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] = 'EXT:mh_httpbl/class.tx_mhhttpbl.php:&tx_mhhttpbl->addHoneyPot';
?>