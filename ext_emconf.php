<?php
$EM_CONF['mh_httpbl'] = [
    'title' => 'http:BL Blocking',
    'description' => 'Implements the http:BL blocking into TYPO3. Block spam bots and other "bad users" from your websites. More information at httpbl.org',
    'category' => 'misc',
    'version' => '2.0.3',
    'state' => 'alpha',
    'uploadfolder' => false,
    'createDirs' => '',
    'clearCacheOnLoad' => true,
    'author' => 'Marc Hoersken',
    'author_email' => 'info@marc-hoersken.de',
    'author_company' => '',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-8.7.99',
        ],
        'conflicts' => [],
        'suggests' => []
    ],
    'autoload' => [
        'psr-4' => ['Webenergy\\MhHttpbl\\' => 'Classes']
    ]
];
