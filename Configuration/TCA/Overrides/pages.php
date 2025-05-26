<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

$columns = [
    'tx_httpauthentication_access' => [
        'exclude' => true,
        'l10n_mode' => 'exclude',
        'label' => 'Access definition (LLL)',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_httpauthentication_access',
            'foreign_field' => 'pid',
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('pages', $columns);
ExtensionManagementUtility::addToAllTCAtypes('pages', '--palette--;;tx_httpauthentication_access','','after:editlock');

$GLOBALS['TCA']['pages']['palettes']['tx_httpauthentication_access'] = [
    'label' => 'HTTP Authentication (LLL)',
    'showitem' => 'tx_httpauthentication_access',
];
