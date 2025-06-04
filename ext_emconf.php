<?php

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'HTTP Authentication',
    'description' => 'HTTP Authentication for TYPO3',
    'category' => 'misc',
    'author' => 'Christian Futterlieb',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'version' => '1.0.0-dev',
    'constraints' => [
        'depends' => [
            'php' => '8.1.0-8.4.99',
            'typo3' => '11.5.0-13.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
