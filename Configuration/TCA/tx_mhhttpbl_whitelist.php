<?php
defined('TYPO3_MODE') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:mh_httpbl/Resources/Private/Language/locallang_db.xlf:tx_mhhttpbl_whitelist',
        'label' => 'whitelist_ip',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY crdate',
        #'iconfile' => 'EXT:mh_httpbl/Resources/Public/Icons/whitelist.gif',
        'hideTable' => 0,
        'rootLevel' => 1,
    ],
    'columns' => [
        'cruser_id' => [
            'label' => 'cruser_id',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'pid' => [
            'label' => 'pid',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'crdate' => [
            'label' => 'crdate',
            'config' => [
                'type' => 'passthrough',
            ]
        ],
        'tstamp' => [
            'label' => 'tstamp',
            'config' => [
                'type' => 'passthrough',
            ]
        ],
        'whitelist_ip' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:mh_httpbl/Resources/Private/Language/locallang_db.xlf:tx_mhhttpbl_whitelist.whitelist_ip',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'max' => '15',
                'eval' => 'required,trim',
            ]
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'whitelist_ip']
    ],
    'palettes' => [
    ]
];
