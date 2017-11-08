<?php
defined('TYPO3_MODE') or die();

return [
    'ctrl' => [
        'title' => 'LLL:EXT:mh_httpbl/Resources/Private/Language/locallang_db.xlf:tx_mhhttpbl_blocklog',
        'label' => 'block_ip',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY crdate',
        //'iconfile' => 'EXT:mh_httpbl/Resources/Public/Icons/blocklog.gif',
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
        'block_ip' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:mh_httpbl/Resources/Private/Language/locallang_db.xlf:tx_mhhttpbl_blocklog.block_ip',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'max' => '15',
                'eval' => 'required,trim'
            ]
        ],
        'block_type' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:mh_httpbl/Resources/Private/Language/locallang_db.xlf:tx_mhhttpbl_blocklog.block_type',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'int,nospace'
            ]
        ],
        'block_score' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:mh_httpbl/Resources/Private/Language/locallang_db.xlf:tx_mhhttpbl_blocklog.block_score',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'int,nospace'
            ]
        ],
        'count' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ]
    ],
    'types' => [
        '0' => ['showitem' => 'block_ip, block_type, block_score, count']
    ],
    'palettes' => [
    ]
];
