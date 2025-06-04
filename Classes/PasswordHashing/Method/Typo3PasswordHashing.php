<?php

declare(strict_types=1);

namespace ChristianFutterlieb\T3HttpAuth\PasswordHashing\Method;

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use ChristianFutterlieb\T3HttpAuth\PasswordHashing\MethodInterface;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;
use TYPO3\CMS\Core\Crypto\PasswordHashing\InvalidPasswordHashException;

/**
 * Typo3PasswordHashing
 */
class Typo3PasswordHashing implements MethodInterface
{
    public function __construct(
        private readonly PasswordHashFactory $passwordHashFactory
    ) {}

    public function canHandleHash(
        #[\SensitiveParameter]
        string $hash
    ): bool {
        try {
            $this->passwordHashFactory->get($hash, 'FE');
            return true;
        } catch (InvalidPasswordHashException $invalidPasswordHashException) {}

        return false;
    }

    public function passwordHash(
        #[\SensitiveParameter]
        string $password
    ): string {
        $hash = $this->passwordHashFactory->getDefaultHashInstance('FE')->getHashedPassword($password);
        if ($hash === null) {
            throw new \RuntimeException('Cannot create password hash');
        }
        return $hash;
    }

    public function passwordVerify(
        #[\SensitiveParameter]
        string $password,
        #[\SensitiveParameter]
        string $hash
    ): bool {
        return $this->passwordHashFactory->get($hash, 'FE')->checkPassword($password, $hash);
    }
}
