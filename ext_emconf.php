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
	'shy' => 1,
	'version' => '1.1.8',
	'priority' => '',
	'loadOrder' => '',
	'module' => 'mod1',
	'state' => 'stable',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Marc Hoersken',
	'author_email' => 'info@marc-hoersken.de',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.5.0-6.0.99',
		),
	),
);

