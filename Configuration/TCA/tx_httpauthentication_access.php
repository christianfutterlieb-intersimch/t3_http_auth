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
        'default_sortby' => 'username',
        'rootLevel' => 0,
        //'iconfile' => 'EXT:styleguide/Resources/Public/Icons/tx_styleguide.svg',
        'searchFields' => 'username,description',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'editlock' => 'editlock',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'hideTable' => true,
    ],
    'columns' => [
        'hidden' => [
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
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
            ],
        ],
        'editlock' => [
            'displayCond' => 'HIDE_FOR_NON_ADMINS',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:editlock',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
            ],
        ],
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
                'fieldControl' => [
                    'passwordGenerator' => [
                        'renderType' => 'passwordGenerator',
                    ],
                ],
            ],
        ],
        'description' => [
            'label' => 'LLL:EXT:http_authentication/Resources/Private/Language/locallang_db.xlf:tca.tx_httpauthentication_access.description',
            'config' => [
                'type' => 'text',
                'default' => null,
                'nullable' => true,
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
