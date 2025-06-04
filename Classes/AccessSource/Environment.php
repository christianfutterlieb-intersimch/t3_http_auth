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

    public const OFFSET_IDENTIFICATION = 'EXT_HTTP_AUTHENTICATION_ACCESS_USERNAME';
    public const OFFSET_KEY = 'EXT_HTTP_AUTHENTICATION_ACCESS_PASSWORD';

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
                'username' => $this->getValueFromEnv(self::OFFSET_IDENTIFICATION),
                'password' => $this->getValueFromEnv(self::OFFSET_KEY),
            ]
        ];
    }

    private function getValueFromEnv(string $offset): ?string
    {
        return $_ENV[$offset] ?? $_SERVER[$offset] ?? null;
    }
}
