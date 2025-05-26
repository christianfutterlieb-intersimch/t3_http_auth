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
 * Environment
 */
final class Environment implements AccessSourceInterface
{
    use AccessSourceTrait;

    public function getDefinitions(): array
    {
        return $this->createDefinitionsArrayFromConfig(
            $this->getConfigArray()
        );
    }

    private function getConfigArray(): array
    {
        return [
            [
                'username' => $this->getIdentificationFromEnv(),
                'password' => $this->getKeyFromEnv(),
            ]
        ];
    }

    private function getIdentificationFromEnv(): ?string
    {
        return $_ENV['EXT_HTTP_AUTHENTICATION_ACCESS_USERNAME'] ?? $_SERVER['EXT_HTTP_AUTHENTICATION_ACCESS_USERNAME'] ?? null;
    }

    private function getKeyFromEnv(): ?string
    {
        return $_ENV['EXT_HTTP_AUTHENTICATION_ACCESS_PASSWORD'] ?? $_SERVER['EXT_HTTP_AUTHENTICATION_ACCESS_PASSWORD'] ?? null;
    }
}
