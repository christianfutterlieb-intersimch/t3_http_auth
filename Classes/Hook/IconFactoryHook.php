<?php

declare(strict_types=1);

namespace ChristianFutterlieb\T3HttpAuth\Hook;

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use ChristianFutterlieb\T3HttpAuth\Imaging\IconHandler;

/**
 * IconFactoryHook
 *
 * @deprecated This class can be removed as soon as support for TYPO3 before v13.0 is dropped, see
 *             \ChristianFutterlieb\T3HttpAuth\EventListener\ModifyRecordOverlayIconIdentifierEventListener
 */
final class IconFactoryHook
{
    public function __construct(
        private readonly IconHandler $iconHandler
    ) {}

    /**
     * Implementation of IconFactory hook:
     *
     *   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][\TYPO3\CMS\Core\Imaging\IconFactory::class]['overrideIconOverlay']
     */
    public function postOverlayPriorityLookup(
        string $table,
        array $row,
        array $status,
        string $iconName
    ): string {
        // Do not override an existing icon overlay
        if ($iconName !== '') {
            return $iconName;
        }
        return $this->iconHandler->getIconOverlayForRecord($table, $row) ?? $iconName;
    }
}
