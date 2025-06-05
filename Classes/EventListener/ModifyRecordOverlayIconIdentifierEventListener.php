<?php

declare(strict_types=1);

namespace ChristianFutterlieb\T3HttpAuth\EventListener;

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use ChristianFutterlieb\T3HttpAuth\Imaging\IconHandler;
use TYPO3\CMS\Core\Imaging\Event\ModifyRecordOverlayIconIdentifierEvent;

/**
 * ModifyRecordOverlayIconIdentifierEventListener
 */
final class ModifyRecordOverlayIconIdentifierEventListener
{
    public function __construct(
        private readonly IconHandler $iconHandler
    ) {}

    public function __invoke(ModifyRecordOverlayIconIdentifierEvent $event): void
    {
        // Do not override an existing icon overlay
        if ($event->getOverlayIconIdentifier() !== '') {
            return;
        }

        $iconOverlay = $this->iconHandler->getIconOverlayForRecord($event->getTable(), $event->getRow());
        if ($iconOverlay !== null) {
            $event->setOverlayIconIdentifier($iconOverlay);
        }
    }
}
