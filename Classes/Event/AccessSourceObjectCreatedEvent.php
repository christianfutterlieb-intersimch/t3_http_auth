<?php

declare(strict_types=1);

namespace ChristianFutterlieb\T3HttpAuth\Event;

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use ChristianFutterlieb\T3HttpAuth\AccessSource\AccessSourceInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * AccessSourceObjectCreatedEvent
 */
final class AccessSourceObjectCreatedEvent
{
    public function __construct(
        public readonly string $context,
        public readonly ServerRequestInterface $request,
        private AccessSourceInterface $accessSource,
    ) {}

    public function getAccessSource(): AccessSourceInterface
    {
        return $this->accessSource;
    }

    public function setAccessSource(AccessSourceInterface $accessSource): void
    {
        $this->accessSource = $accessSource;
    }
}
