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

use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use Webenergy\MhHttpbl\Domain\Model\Demand;
use Webenergy\MhHttpbl\Domain\Model\Whitelist;
use Webenergy\MhHttpbl\Domain\Repository\WhitelistRepository;

/**
 * Class WhitelistController
 *
 * @author Julian Hofmann <julian.hofmann@webenergy.de>
 */
class WhitelistController extends BackendController
{
    /**
     * whitelistRepository
     *
     * @var WhitelistRepository
     */
    protected $whitelistRepository;

    /**
     * list action
     *
     * @param \Webenergy\MhHttpbl\Domain\Model\Demand|null $demand
     * @param string $sortField
     * @param int $sortRev
     */
    public function listAction(Demand $demand = null, $sortField = '', $sortRev = 0)
    {
        if ($sortField) {
            $this->whitelistRepository->setDefaultOrderings([
                $sortField => ($sortRev == 1 ? QueryInterface::ORDER_ASCENDING : QueryInterface::ORDER_DESCENDING)
            ]);
        }
        if ($demand === null) {
            $entries = $this->whitelistRepository->findAll();
        } else {
            $entries = $this->whitelistRepository->findDemanded($demand);
        }

        $this->view->assignMultiple([
            'sortField' => $sortField,
            'sortRev' => $sortRev,
            'entries' => $entries
        ]);
    }

    /**
     * action delete
     *
     * @param Whitelist $whitelist
     * @return void
     */
    public function deleteAction(Whitelist $whitelist)
    {
        $message = GeneralUtility::makeInstance(FlashMessage::class,
            'The IP address ' . $whitelist->getIp() . ' has been removed from the whitelist.',
            $whitelist->getIp() . ' has been deleted',
            FlashMessage::OK
        );
        $this->whitelistRepository->remove($whitelist);
        $persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $persistenceManager->persistAll();

        $flashMessageService = $this->objectManager->get(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);

        $this->forward('list');
    }

    /**
     * action add
     *
     * @param Whitelist $whitelist
     * @return void
     */
    public function addAction(Whitelist $whitelist)
    {
        $message = GeneralUtility::makeInstance(FlashMessage::class,
            'The IP address ' . $whitelist->getIp() . ' has been added to the whitelist.',
            $whitelist->getIp() . ' has been added',
            FlashMessage::OK
        );

        $tstamp = new \DateTime();
        $tstamp->setTimestamp($GLOBALS['SIM_ACCESS_TIME']);

        $whitelist->setCrdate($tstamp);
        $whitelist->setTstamp($tstamp);
        $this->whitelistRepository->add($whitelist);
        $persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $persistenceManager->persistAll();

        $flashMessageService = $this->objectManager->get(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);

        $this->forward('list');
    }

    /**
     * @param WhitelistRepository $whitelistRepository
     */
    public function injectWhitelistRepository(WhitelistRepository $whitelistRepository)
    {
        $this->whitelistRepository = $whitelistRepository;
    }
}