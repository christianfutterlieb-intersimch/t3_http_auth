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

    // editlock
    $GLOBALS['TCA']['tx_httpauthentication_access']['ctrl']['editlock'] = 'editlock';
    unset($GLOBALS['TCA']['tx_httpauthentication_access']['ctrl']['enablecolumns']['editlock']);

    // username
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['username']['config']['eval'] .= ',null';

    // password
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['password']['config']['type'] = 'input';
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['password']['config']['eval'] = 'null,password';
    unset($GLOBALS['TCA']['tx_httpauthentication_access']['columns']['password']['config']['fieldControl']['passwordGenerator']);

    // description
    $GLOBALS['TCA']['tx_httpauthentication_access']['columns']['description']['config']['eval'] = 'null';
}
