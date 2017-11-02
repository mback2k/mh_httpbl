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

use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

/**
 * Class StatusController
 *
 * @author Julian Hofmann <julian.hofmann@webenergy.de>
 */
class StatusController extends BackendController
{
    /**
     * show action
     */
    public function showAction()
    {
        $configurationUtility = $this->objectManager->get(ConfigurationUtility::class);
        $extensionConfiguration = $configurationUtility->getCurrentConfiguration('mh_httpbl');

        $this->view->assignMultiple([
            'accesskey' => $extensionConfiguration['accesskey']['value'],
            'type' => $extensionConfiguration['type']['value'],
            'score' => $extensionConfiguration['score']['value'],
            'message' => $extensionConfiguration['message']['value'],
            'quicklink' => $extensionConfiguration['quicklink']['value'],
            'debug' => $extensionConfiguration['debug']['value']
        ]);
    }
}
