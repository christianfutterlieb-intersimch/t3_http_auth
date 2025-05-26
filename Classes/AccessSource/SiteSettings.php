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

use TYPO3\CMS\Core\Site\Entity\Site;

/**
 * SiteSettings
 */
final class SiteSettings implements AccessSourceInterface
{
    use AccessSourceTrait;

    public function __construct(
        private readonly Site $site
    ) {}

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
        $configArray = $this->site->getSettings()->get('access', []);
        if (!is_array($configArray)) {
            throw new \RuntimeException('"access" in SiteSettings must be array"');
        }
        return $configArray;
    }
}
