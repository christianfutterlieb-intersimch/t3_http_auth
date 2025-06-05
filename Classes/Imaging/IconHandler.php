<?php

declare(strict_types=1);

namespace ChristianFutterlieb\T3HttpAuth\Imaging;

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
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * IconHandler
 */
final class IconHandler
{
    /**
     * @var bool[]
     */
    private static $accessDefinitionsCountPerPage = [];

    public function __construct(
        private readonly ConnectionPool $connectionPool
    ) {}

    public function getIconOverlayForRecord(
        string $table,
        array $record,
    ): ?string {
        return match ($table) {
            'pages' => $this->getIconOverlayForPagesRecord($record),
            default => null,
        };
    }

    private function getIconOverlayForPagesRecord(array $record): ?string
    {
        if (!array_key_exists('uid', $record) || !MathUtility::canBeInterpretedAsInteger($record['uid']) || $record['uid'] < 1) {
            return null;
        }

        return $this->pageHasAccessDefinitions((int)$record['uid'])
            ? 'overlay-restricted'
            : null;
    }

    private function pageHasAccessDefinitions(int $pageUid): bool
    {
        if (!array_key_exists($pageUid, self::$accessDefinitionsCountPerPage)) {
            $qb = $this->connectionPool->getQueryBuilderForTable('tx_httpauthentication_access');
            $qb->count('*')->from('tx_httpauthentication_access')->where(
                $qb->expr()->eq('pid', $qb->createNamedParameter($pageUid, Connection::PARAM_INT))
            );
            self::$accessDefinitionsCountPerPage[$pageUid] = $qb->executeQuery()->fetchNumeric()[0] > 0;
        }
        return self::$accessDefinitionsCountPerPage[$pageUid];
    }
}
