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

use Psr\Http\Message\ServerRequestInterface;

/**
 * AccessSourceFactoryInterface
 */
interface AccessSourceFactoryInterface
{
    public function create(
        string $context,
        ServerRequestInterface $request,
    ): AccessSourceInterface;
}
