<?php

declare(strict_types=1);

namespace ChristianFutterlieb\T3HttpAuth\Hook;

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use ChristianFutterlieb\T3HttpAuth\PasswordHashing\MethodFactory;
use TYPO3\CMS\Core\DataHandling\DataHandler;

/**
 * AccessSourceObjectCreatedEvent
 */
final class DataHandlerHook
{
    public function __construct(
        private readonly MethodFactory $passwordHashingMethodFactory,
    ) {}

    public function processDatamap_preProcessFieldArray(
        array &$incomingFieldArray,
        string $table,
        string|int $id,
        DataHandler $dataHandler
    ): void {
        if ($table !== 'tx_httpauthentication_access') {
            return;
        }

        // Password is not touched (or set to null): ignore
        if (!array_key_exists('password', $incomingFieldArray) || $incomingFieldArray['password'] === null) {
            return;
        }

        // Hash the password
        $incomingFieldArray['password'] = $this->passwordHashingMethodFactory->create()->passwordHash(
            $incomingFieldArray['password']
        );
    }
}
