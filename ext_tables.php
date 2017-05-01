<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

if (TYPO3_MODE === 'BE') {
    /**
     * Registers a Backend Module
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Webenergy.MhHttpbl',
        'tools',
        'mhHttpbl',
        '',
        [
            'BlockLog' => 'list,delete,move',
            'Whitelist' => 'list,delete,add',
            'IpOnly' => 'list',
            'Status' => 'show'
        ],
        [
            'access' => 'admin',
            'icon' => 'EXT:mh_httpbl/Resources/Public/Icons/Module.svg',
            'labels' => 'LLL:EXT:mh_httpbl/Resources/Private/Language/locallang_backend.xml',
        ]
    );
}