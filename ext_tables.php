<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {
        $settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['color_manager']);

        if (TYPO3_MODE === 'BE') {
            if ($settings['showAdministrationModule']) {
                \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                    'LST.ColorManager',
                    'tools', // Make module a submodule of 'tools'
                    'admin', // Submodule key
                    '', // Position
                    [
                        'Admin' => 'list',
                    ],
                    [
                        'access' => 'user,group',
                        'icon'   => 'EXT:' . $extKey . '/Resources/Public/Icons/module-admin.png',
                        'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_admin.xlf',
                    ]
                );
            }
        }

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_colormanager_domain_model_color', 'EXT:color_manager/Resources/Private/Language/locallang_csh_tx_colormanager_domain_model_color.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_colormanager_domain_model_color');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
            'module.tx_colormanager_tools_colormanageradmin.persistence.storagePid = ' . $settings['globalStoragePid']
        );
    },
    $_EXTKEY
);

// Register hooks
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'LST\ColorManager\Hook\TcaHook';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] = 'LST\ColorManager\Hook\TcaHook';
