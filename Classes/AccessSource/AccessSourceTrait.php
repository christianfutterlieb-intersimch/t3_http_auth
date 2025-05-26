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
 * AccessSourceTrait
 */
trait AccessSourceTrait
{
    protected function createDefinitionsArrayFromConfig(
        array $accessConfig,
        string $identificationOffset = 'username',
        string $keyOffset = 'password',
    ): array {
        // Filter $accessConfig
        $filtered = array_filter($accessConfig, fn(mixed $entry): bool =>
            is_array($entry)
            // $identificationOffset => string or null
            && array_key_exists($identificationOffset, $entry)
            && (is_string($entry[$identificationOffset]) || $entry[$identificationOffset] === null)
            // $keyOffset => string or null
            && array_key_exists($keyOffset, $entry)
            && (is_string($entry[$keyOffset]) || $entry[$keyOffset] === null)
            // Not both offsets can be null
            && !($entry[$identificationOffset] === null && $entry[$keyOffset] === null)
        );

        // Create definitions
        return array_map(
            fn(array $entry): Definition =>
                new Definition(
                    $entry[$identificationOffset],
                    $entry[$keyOffset],
                    static::class
                ),
            $filtered
        );
    }
}
