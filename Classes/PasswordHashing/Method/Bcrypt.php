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
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * Bcrypt
 */
class Bcrypt implements MethodInterface
{
    private const DEFAULT_BCRYPT_COST = 8;

    public function __construct(
        private readonly ExtensionConfiguration $extConf,
    ) {}

    public function canHandleHash(
        #[\SensitiveParameter]
        string $hash
    ): bool {
        return password_get_info($hash)['algo'] === PASSWORD_BCRYPT;
    }

    public function passwordHash(
        #[\SensitiveParameter]
        string $password
    ): string {
        return password_hash(
            $password,
            PASSWORD_BCRYPT,
            [
                'cost' => $this->getBcryptCostFromConfiguration(),
            ]
        );
    }

    public function passwordVerify(
        #[\SensitiveParameter]
        string $password,
        #[\SensitiveParameter]
        string $hash
    ): bool {
        return password_verify($password, $hash);
    }

    private function getBcryptCostFromConfiguration(): int
    {
        $bcryptCost = $this->extConf->get('http_authentication')['passwordHashingBcryptCost'] ?? self::DEFAULT_BCRYPT_COST;
        if (!MathUtility::canBeInterpretedAsInteger($bcryptCost) || $bcryptCost < 4 || $bcryptCost > 17) {
            throw new \RuntimeException('$GLOBALS["TYPO3_CONF_VARS"]["EXTENSIONS"]["http_authentication"]["passwordHashingBcryptCost"] must be integer between 4 and 17');
        }
        return (int)$bcryptCost;
    }
}
