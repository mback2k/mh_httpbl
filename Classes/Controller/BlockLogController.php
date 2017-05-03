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
use Webenergy\MhHttpbl\Domain\Model\BlockLog;
use Webenergy\MhHttpbl\Domain\Model\Demand;
use Webenergy\MhHttpbl\Domain\Model\Whitelist;
use Webenergy\MhHttpbl\Domain\Repository\BlockLogRepository;
use Webenergy\MhHttpbl\Domain\Repository\WhitelistRepository;

/**
 * Class BlockLogController
 *
 * @author Julian Hofmann <julian.hofmann@webenergy.de>
 */
class BlockLogController extends BackendController
{
    /**
     * blockLogRepository
     *
     * @var BlockLogRepository
     */
    protected $blockLogRepository;

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
            $this->blockLogRepository->setDefaultOrderings([
                $sortField => ($sortRev == 1 ? QueryInterface::ORDER_ASCENDING : QueryInterface::ORDER_DESCENDING)
            ]);
        }
        if ($demand === null) {
            $entries = $this->blockLogRepository->findAll();
        } else {
            $entries = $this->blockLogRepository->findDemanded($demand);
        }

        $this->view->assignMultiple([
            'sortField' => $sortField,
            'sortRev' => $sortRev,
            'demand' => $demand,
            'entries' => $entries
        ]);
    }

    /**
     * action delete
     *
     * @param BlockLog $blockLog
     * @return void
     */
    public function deleteAction(BlockLog $blockLog)
    {
        $message = GeneralUtility::makeInstance(FlashMessage::class,
            'The IP adress ' . $blockLog->getIp() . ' has been removed from the list of blocked IPs.',
            $blockLog->getIp() . ' has been deleted',
            FlashMessage::OK
        );
        $this->blockLogRepository->remove($blockLog);
        $persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $persistenceManager->persistAll();

        $flashMessageService = $this->objectManager->get(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);

        $this->forward('list');
    }

    /**
     * action move
     *
     * @param BlockLog $blockLog
     * @return void
     */
    public function moveAction(BlockLog $blockLog)
    {
        $message = GeneralUtility::makeInstance(FlashMessage::class,
            'The IP adress ' . $blockLog->getIp() . ' has been moved to the whitelist.',
            $blockLog->getIp() . ' has been moved',
            FlashMessage::OK
        );

        $tstamp = new \DateTime();
        $tstamp->setTimestamp($GLOBALS['SIM_ACCESS_TIME']);

        $whitelist = new Whitelist();
        $whitelist->setIp($blockLog->getIp());
        $whitelist->setCrdate($tstamp);
        $whitelist->setTstamp($tstamp);

        $this->whitelistRepository->add($whitelist);
        $this->blockLogRepository->remove($blockLog);
        $persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $persistenceManager->persistAll();

        $flashMessageService = $this->objectManager->get(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);

        $this->forward('list');
    }

    /**
     * @param BlockLogRepository $blockLogRepository
     */
    public function injectBlockLogRepository(BlockLogRepository $blockLogRepository)
    {
        $this->blockLogRepository = $blockLogRepository;
    }

    /**
     * @param WhitelistRepository $whitelistRepository
     */
    public function injectWhitelistRepository(WhitelistRepository $whitelistRepository)
    {
        $this->whitelistRepository = $whitelistRepository;
    }
}