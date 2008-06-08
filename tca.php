<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_mhhttpbl_blocklog"] = array (
	"ctrl" => $TCA["tx_mhhttpbl_blocklog"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "block_ip,block_type,block_score"
	),
	"feInterface" => $TCA["tx_mhhttpbl_blocklog"]["feInterface"],
	"columns" => array (
		"block_ip" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:mh_httpbl/locallang_db.xml:tx_mhhttpbl_blocklog.block_ip",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "15",	
				"eval" => "required,trim",
			)
		),
		"block_type" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:mh_httpbl/locallang_db.xml:tx_mhhttpbl_blocklog.block_type",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "int,nospace",
			)
		),
		"block_score" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:mh_httpbl/locallang_db.xml:tx_mhhttpbl_blocklog.block_score",		
			"config" => Array (
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
	"ctrl" => $TCA["tx_mhhttpbl_whitelist"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "whitelist_ip"
	),
	"feInterface" => $TCA["tx_mhhttpbl_whitelist"]["feInterface"],
	"columns" => array (
		"whitelist_ip" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:mh_httpbl/locallang_db.xml:tx_mhhttpbl_whitelist.whitelist_ip",		
			"config" => Array (
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
?>