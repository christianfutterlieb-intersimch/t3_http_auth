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

/**
 * MethodInterface
 */
interface MethodInterface
{
    public function canHandleHash(
        #[\SensitiveParameter]
        string $hash
    ): bool;

    public function passwordHash(
        #[\SensitiveParameter]
        string $password
    ): string;

    public function passwordVerify(
        #[\SensitiveParameter]
        string $password,
        #[\SensitiveParameter]
        string $hash
    ): bool;
}
