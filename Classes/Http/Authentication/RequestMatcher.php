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

use ChristianFutterlieb\T3HttpAuth\AccessSource\Definition;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Crypto\PasswordHashing\InvalidPasswordHashException;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;

/**
 * RequestMatcher
 */
final class RequestMatcher implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly PasswordHashFactory $passwordHashFactory
    ) {}

    public function matchesDefinition(#[\SensitiveParameter]Definition $definition, #[\SensitiveParameter] Request $authenticationRequest): bool
    {
        return $this->verifyIdentification($definition->identification, $authenticationRequest->getIdentification())
               && $this->verifyKey($definition->key, $authenticationRequest->getKey());
    }

    private function verifyIdentification(?string $knownIdentification, ?string $userInput): bool
    {
        // No identification required
        if ($knownIdentification === null) {
            return true;
        }
        return hash_equals($knownIdentification, (string)$userInput);
    }

    private function verifyKey(#[\SensitiveParameter] ?string $knownKey, #[\SensitiveParameter] ?string $userInput): bool
    {
        // No key required
        if ($knownKey === null) {
            return true;
        }

        $userInput = (string)$userInput;

        // TYPO3 password hashing
        if ($this->verifyPasswordHashTYPO3($knownKey, $userInput)) {
            return true;
        }

        // PHP-builtin password hashing
        // This is used as a fallback, especially for bcrypt hashing, where
        // TYPO3 does not comply 100% with what could be expected (which is not
        // bad, but we want to stay compatible with tools like htpasswd).
        if ($this->verifyPasswordHashPHP($knownKey, $userInput)) {
            return true;
        }

        return false;
    }

    private function verifyPasswordHashPHP(#[\SensitiveParameter] string $knownKey, #[\SensitiveParameter] string $userInput): bool
    {
        $passwordAlgo = password_get_info($knownKey)['algo'] ?? null;
        if ($passwordAlgo !== null && in_array($passwordAlgo, password_algos(), true)) {
            return password_verify($userInput, $knownKey);
        }
        $this->logger->warning('Cannot use PHP builtin password hashing: unknown or unsupported password hashing algo', [
            'algo' => $passwordAlgo,
        ]);
        return false;
    }

    private function verifyPasswordHashTYPO3(#[\SensitiveParameter] string $knownKey, #[\SensitiveParameter] string $userInput): bool
    {
        try {
            return $this->passwordHashFactory->get($knownKey, 'FE')->checkPassword($userInput, $knownKey);
        } catch (InvalidPasswordHashException $invalidPasswordHashException) {
            $this->logger->warning('Cannot use TYPO3 password hashing, caught ' . InvalidPasswordHashException::class, [
                'message' => $invalidPasswordHashException->getMessage(),
                'code' => $invalidPasswordHashException->getCode(),
                'file' => $invalidPasswordHashException->getFile(),
                'line' => $invalidPasswordHashException->getLine(),
            ]);
        }
        return false;
    }
}
