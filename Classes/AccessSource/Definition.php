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

/**
 * Definition
 */
final class Definition
{
    public function __construct(
        public readonly ?string $identification,
        public readonly ?string $key,
        public readonly string $source,
    ) {}
}
