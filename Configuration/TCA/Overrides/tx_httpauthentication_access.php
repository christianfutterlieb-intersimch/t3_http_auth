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
use TYPO3\CMS\Core\Utility\GeneralUtility;

// TYPO3 v12.4 compatibility
if (GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion() < 13) {
    // Auto-created columns from 'ctrl' (as of TYPO3 v13)
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['hidden'] = [
        'exclude' => true,
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'items' => [
                [
                    'label' => '',
                    'invertStateDisplay' => true,
                ],
            ],
        ],
    ];
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['starttime'] = [
        'exclude' => true,
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
        'config' => [
            'type' => 'datetime',
            'default' => 0,
        ],
    ];
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['endtime'] = [
        'exclude' => true,
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
        'config' => [
            'type' => 'datetime',
            'default' => 0,
            'range' => [
                'upper' => mktime(0, 0, 0, 1, 1, 2038),
            ],
        ],
    ];
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['editlock'] = [
        'displayCond' => 'HIDE_FOR_NON_ADMINS',
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:editlock',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
        ],
    ];
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['description'] = [
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.description',
        'config' => [
            'type' => 'text',
            'default' => null,
            'nullable' => true,
        ],
    ];
}

// TYPO3 v11.5 compatibility
if (GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion() < 12) {
    // hidden
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['hidden']['config']['items'][0][0] = $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['hidden']['config']['items'][0]['label'];
    unset ($GLOBALS['TCA']['tx_httpauthentication_access']['columns']['hidden']['config']['items'][0]['label']);

    // starttime
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['starttime']['config']['type'] = 'input';
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['starttime']['config']['renderType'] = 'inputDateTime';
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['starttime']['config']['eval'] = 'datetime,int';
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['starttime']['config']['type'] = 'input';

    // endtime
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['endtime']['config']['type'] = 'input';
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['endtime']['config']['renderType'] = 'inputDateTime';
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['endtime']['config']['eval'] = 'datetime,int';
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['endtime']['config']['range'] = [
        'upper' => mktime(0, 0, 0, 1, 1, 2038),
    ];

    // username
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['username']['config']['eval'] .= ',null';

    // password
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['password']['config']['type'] = 'input';
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['password']['config']['eval'] = 'null,password';
    unset($GLOBALS['TCA']['tx_httpauthentication_access']['columns']['password']['config']['fieldControl']['passwordGenerator']);

    // description
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['description']['config']['eval'] = 'null';
}
