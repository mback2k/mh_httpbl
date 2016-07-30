<?php

/**
 * Extension Manager/Repository config file for ext "mh_httpbl".
 *
 * Auto generated 31-05-2016 12:37
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 */

$EM_CONF[$_EXTKEY] = array(
	'title' => 'http:BL Blocking',
	'description' => 'Implements the http:BL blocking into TYPO3. Block spam bots and other "bad users" from your websites. More information at httpbl.org',
	'category' => 'misc',
	'shy' => 0,
	'version' => '1.1.9',
	'priority' => '',
	'loadOrder' => '',
	'module' => 'mod1',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Marc Hoersken',
	'author_email' => 'info@marc-hoersken.de',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array (
		'depends' => array (
			'php' => '4.3.0-0.0.0',
			'typo3' => '4.0.0-6.2.99',
		),
		'conflicts' => array (
		),
		'suggests' => array (
		),
	),
);

