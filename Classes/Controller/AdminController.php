<?php
declare(strict_types = 1);

/***
 *
 * This file is part of the "Color Manager" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2016 Christian Fries <christian.fries@lst.team>
 *
 ***/

namespace LST\ColorManager\Controller;

use LST\BackendModule\Controller\BackendModuleActionController;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

class AdminController extends BackendModuleActionController
{
    /**
     * @Extbase\Inject
     * @var \LST\ColorManager\Domain\Repository\ColorRepository
     */
    protected $colorRepository = null;

    /**
     * Set up the doc header properly here
     *
     * @param ViewInterface $view
     * @return void
     */
    protected function initializeView(ViewInterface $view)
    {
        /** @var BackendTemplateView $view */
        parent::initializeView($view);
        if ($view instanceof BackendTemplateView) {
            $view->getModuleTemplate()->getPageRenderer()->loadRequireJsModule('TYPO3/CMS/Backend/Modal');
        }
    }

    /**
     * Function will be called before every other action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->extKey = 'color_manager';
        $this->moduleName = 'tools_ColorManagerAdmin';
        $this->showConfigurationButton = true;

        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('color_manager');
        $this->pageUid = intval($extensionConfiguration['globalStoragePid']);

        parent::initializeAction();

        $this->setButtons([
            $this->createNewRecordButton(
                'tx_colormanager_domain_model_color',
                $this->getLanguageService()->sL('LLL:EXT:color_manager/Resources/Private/Language/locallang.xlf:color.new')
            )
        ]);
    }

    /**
     * @return void
     */
    public function listAction()
    {
        $colors = $this->colorRepository->findAll();
        $this->view->assign('colors', $colors);
    }
}
