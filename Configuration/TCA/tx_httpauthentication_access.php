<?php

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

return [
    'ctrl' => [
        'title' => 'LLL:EXT:http_authentication/Resources/Private/Language/locallang_db.xlf:tca.tx_httpauthentication_access',
        'label' => 'username',
        'label_alt' => 'description',
        'descriptionColumn' => 'description',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'sortby' => 'sorting',
        'editlock' => 'editlock',
        'default_sortby' => 'username',
        'typeicon_classes' => [
            'default' => 'actions-lock',
        ],
        'searchFields' => 'username,description',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'hideTable' => true,
    ],
    'columns' => [
        'username' => [
            'label' => 'LLL:EXT:http_authentication/Resources/Private/Language/locallang_db.xlf:tca.tx_httpauthentication_access.username',
            'config' => [
                'type' => 'input',
                'default' => null,
                'nullable' => true,
                'eval' => 'alphanum',
                'max' => 45,
            ],
        ],
        'password' => [
            'label' => 'LLL:EXT:http_authentication/Resources/Private/Language/locallang_db.xlf:tca.tx_httpauthentication_access.password',
            'config' => [
                'type' => 'password',
                'default' => null,
                'nullable' => true,
                // Do not let TYPO3 do the hashing: it is done in DataHandlerHook, dependent on the configured hashing method
                'hashed' => false,
                'fieldControl' => [
                    'passwordGenerator' => [
                        'renderType' => 'passwordGenerator',
                    ],
                ],
            ],
        ],
    ],
    'palettes' => [
        'access' => [
            'showitem' => 'starttime, endtime, --linebreak--, editlock',
        ],
        'visibility' => [
            'showitem' => 'hidden',
        ],
    ],
    'types' => [
        0 => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    username,
                    password,
                    description,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;visibility,
                    --palette--;;access,
            ',
        ],
    ],
];
