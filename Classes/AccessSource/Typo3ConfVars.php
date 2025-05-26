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
 * Typo3ConfVars
 */
final class Typo3ConfVars implements AccessSourceInterface
{
    use AccessSourceTrait;

    public function getDefinitions(): array
    {
        $configArray = $this->getConfigArray();
        if ($configArray === []) {
            return [];
        }
        return $this->createDefinitionsArrayFromConfig($configArray);
    }


    private function getConfigArray(): array
    {
        $configArray = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['http_authentication']['access'] ?? [];
        if (!is_array($configArray)) {
            throw new \RuntimeException('$GLOBALS["TYPO3_CONF_VARS"]["EXTCONF"]["http_authentication"]["access"] must be array');
        }
        return $configArray;
    }
}
