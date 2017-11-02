<?php
namespace Webenergy\MhHttpbl\Controller;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Lang\LanguageService;

/**
 * Class BackendController
 *
 * @author Julian Hofmann <julian.hofmann@webenergy.de>
 */
abstract class BackendController extends ActionController
{
    /**
     * @var BackendTemplateView
     */
    protected $view;

    /**
     * BackendTemplateView Container
     *
     * @var BackendTemplateView
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

    /**
     * Module name for the shortcut
     *
     * @var string
     */
    protected $shortcutName;

    /**
     * @var array
     */
    protected $settings = [];

    /**
     *
     */
    public function initializeAction()
    {
        $this->settings = $this->configurationManager->getConfiguration(
            'Settings',
            $this->request->getControllerExtensionName(),
            $this->request->getControllerName()
        );
    }

    /**
     * Initialize the view
     *
     * @param ViewInterface $view The view
     */
    public function initializeView(ViewInterface $view)
    {
        /** @var BackendTemplateView $view */
        parent::initializeView($view);
        $this->view->assign('settings', $this->settings);

        // Only show/list-action have currently templates
        if (in_array($this->controllerContext->getRequest()->getControllerActionName(), ['show', 'list'])) {
            $view->getModuleTemplate()->getDocHeaderComponent()->setMetaInformation([]);
            $this->generateMenu();
            $this->generateButtons();
        }
    }

    /**
     * Generates the menu
     */
    protected function generateMenu()
    {
        $lang = $this->getLanguageService();
        $lang->includeLLFile('EXT:mh_httpbl/Resources/Private/Language/locallang_backend.xlf');

        $this->shortcutName = $lang->getLL('shortcutName');

        $menu = $this->view->getModuleTemplate()->getDocHeaderComponent()->getMenuRegistry()->makeMenu();
        $menu->setIdentifier('WebFuncJumpMenu');

        $menuItem = $menu
            ->makeMenuItem()
            ->setHref(
                $this->uriBuilder->reset()->uriFor('list', null, 'BlockLog')
            )
            ->setTitle($lang->getLL('blocklog_overview'));
        if ($this->request->getControllerName() == 'BlockLog' && $this->request->getControllerActionName() == 'list') {
            $menuItem->setActive(true);
            $this->shortcutName = $lang->getLL('shortcutName') . ' - ' . $lang->getLL('blocklog_overview');
        }
        $menu->addMenuItem($menuItem);

        $menuItem = $menu
            ->makeMenuItem()
            ->setHref(
                $this->uriBuilder->reset()->uriFor('list', null, 'Whitelist')
            )
            ->setTitle($lang->getLL('whitelist_overview'));
        if ($this->request->getControllerName() == 'Whitelist' && $this->request->getControllerActionName() == 'list') {
            $menuItem->setActive(true);
            $this->shortcutName = $lang->getLL('shortcutName') . ' - ' . $lang->getLL('whitelist_overview');
        }
        $menu->addMenuItem($menuItem);

        $menuItem = $menu
            ->makeMenuItem()
            ->setHref(
                $this->uriBuilder->reset()->uriFor('list', null, 'IpOnly')
            )
            ->setTitle($lang->getLL('iponly_overview'));
        if ($this->request->getControllerName() == 'IpOnly' && $this->request->getControllerActionName() == 'list') {
            $menuItem->setActive(true);
            $this->shortcutName = $lang->getLL('shortcutName') . ' - ' . $lang->getLL('iponly_overview');
        }
        $menu->addMenuItem($menuItem);

        $menuItem = $menu
            ->makeMenuItem()
            ->setHref(
                $this->uriBuilder->reset()->uriFor('show', null, 'Status')
            )
            ->setTitle($lang->getLL('status_overview'));
        if ($this->request->getControllerName() == 'Status' && $this->request->getControllerActionName() == 'show') {
            $menuItem->setActive(true);
            $this->shortcutName = $lang->getLL('shortcutName') . ' - ' . $lang->getLL('status_overview');
        }
        $menu->addMenuItem($menuItem);

        $this->view->getModuleTemplate()->getDocHeaderComponent()->getMenuRegistry()->addMenu($menu);
    }

    /**
     * Gets all buttons for the docheader
     */
    protected function generateButtons()
    {
        $buttonBar = $this->view->getModuleTemplate()->getDocHeaderComponent()->getButtonBar();
        $moduleName = $this->request->getPluginName();
        $getVars = $this->request->hasArgument('getVars') ? $this->request->getArgument('getVars') : [];
        $setVars = $this->request->hasArgument('setVars') ? $this->request->getArgument('setVars') : [];
        if (count($getVars) === 0) {
            $modulePrefix = strtolower('tx_' . $this->request->getControllerExtensionName() . '_' . $moduleName);
            $getVars = ['id', 'M', $modulePrefix];
        }
        $shortcutButton = $buttonBar->makeShortcutButton()
            ->setModuleName($moduleName)
            ->setGetVariables($getVars)
            ->setDisplayName($this->shortcutName)
            ->setSetVariables($setVars);
        $buttonBar->addButton($shortcutButton);
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }
}
