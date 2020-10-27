<?php
defined('TYPO3_MODE') or die();

(function () {
    // Load extension configuration
    $extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
    )->get('color_manager');
    $navigationComponent = (!$extensionConfiguration['globalStoragePid']) ? 'typo3-pagetree' : '';

    if ($extensionConfiguration['showAdministrationModule']) {
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
                'icon'   => 'EXT:color_manager/Resources/Public/Icons/module-admin.png',
                'labels' => 'LLL:EXT:color_manager/Resources/Private/Language/locallang_admin.xlf',
                'navigationComponentId' => $navigationComponent,
                'inheritNavigationComponentFromMainModule' => false
            ]
        );
    }

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_colormanager_domain_model_color');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        'module.tx_colormanager_tools_colormanageradmin.persistence.storagePid = ' . $extensionConfiguration['globalStoragePid']
    );
})();

// Register hooks
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'LST\ColorManager\Hook\TcaHook';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] = 'LST\ColorManager\Hook\TcaHook';
