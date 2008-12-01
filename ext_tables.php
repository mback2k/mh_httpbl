<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_mhhttpbl_blocklog"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:mh_httpbl/locallang_db.xml:tx_mhhttpbl_blocklog',		
		'label'     => 'block_ip',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_mhhttpbl_blocklog.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "block_ip, block_type, block_score",
	)
);

$TCA["tx_mhhttpbl_whitelist"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:mh_httpbl/locallang_db.xml:tx_mhhttpbl_whitelist',		
		'label'     => 'whitelist_ip',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_mhhttpbl_whitelist.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "whitelist_ip",
	)
);

if (TYPO3_MODE == 'BE')	{
	t3lib_extMgm::addModule('tools','txmhhttpblM1','',t3lib_extMgm::extPath($_EXTKEY).'mod1/');
}

?>