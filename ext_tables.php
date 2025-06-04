<?php

declare(strict_types=1);

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') || die();

// TYPO3 v11.5 compatibility
if (GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion() < 12) {
    ExtensionManagementUtility::allowTableOnStandardPages('tx_httpauthentication_access');
}
