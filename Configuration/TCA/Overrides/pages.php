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

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$columns = [
    'tx_httpauthentication_access' => [
        'exclude' => true,
        'l10n_mode' => 'exclude',
        'label' => 'LLL:EXT:http_authentication/Resources/Private/Language/locallang_db.xlf:tca.pages.tx_httpauthentication_access',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_httpauthentication_access',
            'foreign_field' => 'pid',
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('pages', $columns);

$GLOBALS['TCA']['pages']['palettes']['tx_httpauthentication_access'] = [
    'label' => 'LLL:EXT:http_authentication/Resources/Private/Language/locallang_db.xlf:tca.pages.palettes.tx_httpauthentication_access',
    'showitem' => 'tx_httpauthentication_access',
];

// Add the palette to the standard pages (if pageBasedAccess is enabled)
if ((bool)GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('http_authentication', 'pageBasedAccess')) {
    ExtensionManagementUtility::addToAllTCAtypes(
        'pages',
        '--palette--;;tx_httpauthentication_access',
        (string)PageRepository::DOKTYPE_DEFAULT,
        'after:editlock'
    );
}
