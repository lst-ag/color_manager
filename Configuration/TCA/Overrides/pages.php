<?php
defined('TYPO3_MODE') or die();

(function () {
    $columns = [
        'tx_colormanager_color_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:color_manager/Resources/Private/Language/locallang_db.xlf:color.color',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [ 'LLL:EXT:color_manager/Resources/Private/Language/locallang_db.xlf:color.color.choose', '' ]
                ],
                'foreign_table' => 'tx_colormanager_domain_model_color',
                'foreign_table_where' => 'ORDER BY tx_colormanager_domain_model_color.name',
                'default' => ''
            ],
        ],
        'tx_colormanager_color' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ]
    ];

    $palette = '--palette--;LLL:EXT:color_manager/Resources/Private/Language/locallang_db.xlf:color.palette.title;color';

    $GLOBALS['TCA']['pages']['palettes']['color']['showitem'] = 'tx_colormanager_color_uid';

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $columns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages', $palette, '', 'after:subtitle');
})();
