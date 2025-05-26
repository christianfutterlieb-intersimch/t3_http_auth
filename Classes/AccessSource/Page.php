<?php

declare(strict_types=1);

namespace ChristianFutterlieb\T3HttpAuth\AccessSource;

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Page
 */
final class Page implements AccessSourceInterface
{
    use AccessSourceTrait;

    private ?array $accessRecords = null;

    public function __construct(
        private readonly int $pageUid
    ) {}

    public function getDefinitions(): array
    {
        $this->loadData();

        if ($this->accessRecords === []) {
            return [];
        }

        return $this->createDefinitionsArrayFromConfig($this->accessRecords);
    }

    private function loadData()
    {
        if (is_null($this->accessRecords)) {
            $this->accessRecords = $this->getConnectionForTable('tx_httpauthentication_access')
                ->select(
                    [
                        'username',
                        'password',
                    ],
                    'tx_httpauthentication_access',
                    [
                        'pid' => $this->pageUid,
                    ]
                )
                ->fetchAllAssociative();
        }
    }

    private function getConnectionForTable(string $tableName): Connection
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($tableName);
    }
}
