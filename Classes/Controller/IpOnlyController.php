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

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use Webenergy\MhHttpbl\Domain\Repository\BlockLogRepository;

/**
 * Class IpOnlyController
 *
 * @author Julian Hofmann <julian.hofmann@webenergy.de>
 */
class IpOnlyController extends BackendController
{
    /**
     * blockLogRepository
     *
     * @var BlockLogRepository
     */
    protected $blockLogRepository;

    /**
     * list action
     *
     * @param string $sortField
     * @param int $sortRev
     */
    public function listAction($sortField = '', $sortRev = 0)
    {
        if ($sortField) {
            $this->blockLogRepository->setDefaultOrderings([
                $sortField => ($sortRev == 1 ? QueryInterface::ORDER_ASCENDING : QueryInterface::ORDER_DESCENDING)
            ]);
        } else {
            $this->blockLogRepository->setDefaultOrderings([
                'count' => QueryInterface::ORDER_DESCENDING
            ]);
        }
        $entries = $this->blockLogRepository->findAllGroupedByIp();

        $this->view->assignMultiple([
            'sortField' => $sortField,
            'sortRev' => $sortRev,
            'entries' => $entries
        ]);
    }

    /**
     * @param BlockLogRepository $blockLogRepository
     */
    public function injectBlockLogRepository(BlockLogRepository $blockLogRepository)
    {
        $this->blockLogRepository = $blockLogRepository;
    }
}