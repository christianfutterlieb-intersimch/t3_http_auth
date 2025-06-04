<?php

declare(strict_types=1);

namespace ChristianFutterlieb\T3HttpAuth\PasswordHashing;

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use ChristianFutterlieb\T3HttpAuth\PasswordHashing\Method\Bcrypt;
use ChristianFutterlieb\T3HttpAuth\PasswordHashing\Method\Typo3PasswordHashing;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * MethodFactory
 */
class MethodFactory
{
    public function __construct(
        private readonly ExtensionConfiguration $extConf,
    ) {}

    public function create(): MethodInterface
    {
        $passwordHashingInDatabase = (string)$this->extConf->get('http_authentication', 'passwordHashingInDatabase');
        if ($passwordHashingInDatabase === 'typo3') {
            return GeneralUtility::makeInstance(Typo3PasswordHashing::class);
        }

        if ($passwordHashingInDatabase === 'apr1') {
            throw new \RuntimeException('Apache-style MD5 salted hashing is not yet implemented');
        }

        // By default use bcrypt
        return GeneralUtility::makeInstance(Bcrypt::class);
    }

    /**
     * @return MethodInterface[]
     */
    public function createForHash(
        #[\SensitiveParameter]
        string $hash
    ): array {
        $return = [];
        foreach ($this->getAvailableMethodClassNames() as $methodClassName) {
            /** @var MethodInterface $method */
            $method = GeneralUtility::makeInstance($methodClassName);
            if ($method->canHandleHash($hash)) {
                $return[] = $method;
            }
        }

        if ($return === []) {
            throw new \RuntimeException('Cannot find a password hashing method suited for the given hash');
        }
        return $return;
    }

    /**
     * @return string[]
     */
    private function getAvailableMethodClassNames(): array
    {
        return [
            Bcrypt::class,
            Typo3PasswordHashing::class,
        ];
    }
}
