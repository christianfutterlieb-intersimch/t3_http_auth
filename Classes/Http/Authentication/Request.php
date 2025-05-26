<?php

declare(strict_types=1);

namespace ChristianFutterlieb\T3HttpAuth\Http\Authentication;

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Request
 */
final class Request implements RequestInterface
{
    public function __construct(
        protected ?string $identification = null,
        protected ?string $key = null,
    ) {}

    public function getIdentification(): ?string
    {
        return $this->identification;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }
}
