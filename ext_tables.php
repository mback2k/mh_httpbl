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
		'iconfile'  => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon.gif',
		'hideTable' => 1,
		'rootLevel' => 1,
	),
	"interface" => array (
		"showRecordFieldList" => "block_ip, block_type, block_score",
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "block_ip, block_type, block_score",
	),
	"columns" => array (
		"block_ip" => array (
			"exclude" => 1,
			"label" => "LLL:EXT:mh_httpbl/locallang_db.xml:tx_mhhttpbl_blocklog.block_ip",
			"config" => array (
				"type" => "input",
				"size" => "30",
				"max" => "15",
				"eval" => "required,trim",
			)
		),
		"block_type" => array (
			"exclude" => 1,
			"label" => "LLL:EXT:mh_httpbl/locallang_db.xml:tx_mhhttpbl_blocklog.block_type",
			"config" => array (
				"type" => "input",
				"size" => "30",
				"eval" => "int,nospace",
			)
		),
		"block_score" => array (
			"exclude" => 1,
			"label" => "LLL:EXT:mh_httpbl/locallang_db.xml:tx_mhhttpbl_blocklog.block_score",
			"config" => array (
				"type" => "input",
				"size" => "30",
				"eval" => "int,nospace",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "block_ip;;;;1-1-1, block_type, block_score")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
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
		'iconfile'  => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon.gif',
		'hideTable' => 1,
		'rootLevel' => 1,
	),
	"interface" => array (
		"showRecordFieldList" => "whitelist_ip",
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "whitelist_ip",
	),
	"columns" => array (
		"whitelist_ip" => array (
			"exclude" => 1,
			"label" => "LLL:EXT:mh_httpbl/locallang_db.xml:tx_mhhttpbl_whitelist.whitelist_ip",
			"config" => array (
				"type" => "input",
				"size" => "30",
				"max" => "15",
				"eval" => "required,trim",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "whitelist_ip;;;;1-1-1")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);

if (TYPO3_MODE == 'BE')	{
	t3lib_extMgm::addModule('tools','txmhhttpblM1','',t3lib_extMgm::extPath($_EXTKEY).'mod1/');
}

?>
