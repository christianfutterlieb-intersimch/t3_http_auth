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
use ChristianFutterlieb\T3HttpAuth\PasswordHashing\MethodFactory;

/**
 * RequestMatcher
 */
final class RequestMatcher
{
    public function __construct(
        private readonly MethodFactory $passwordHashingMethodFactory,
    ) {}

    public function matchesDefinition(
        #[\SensitiveParameter]
        Definition $definition,
        #[\SensitiveParameter]
        Request $authenticationRequest
    ): bool {
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

    private function verifyKey(
        #[\SensitiveParameter]
        ?string $knownKey,
        #[\SensitiveParameter]
        ?string $userInput
    ): bool {
        // No key required
        if ($knownKey === null) {
            return true;
        }

        foreach ($this->passwordHashingMethodFactory->createForHash($knownKey) as $hashingMethod) {
            if ($hashingMethod->passwordVerify((string)$userInput, $knownKey)) {
                return true;
            }
        }

        return false;
    }
}
