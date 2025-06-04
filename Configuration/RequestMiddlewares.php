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

use ChristianFutterlieb\T3HttpAuth\Http\Middleware\HttpAuthenticationEnv;
use ChristianFutterlieb\T3HttpAuth\Http\Middleware\HttpAuthenticationGlobal;
use ChristianFutterlieb\T3HttpAuth\Http\Middleware\HttpAuthenticationPage;
use ChristianFutterlieb\T3HttpAuth\Http\Middleware\HttpAuthenticationSite;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/** @var ExtensionConfiguration $extConf */
$extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class);

return [
    'frontend' => [
        'christianfutterlieb/t3_http_auth/http-authentication-env' => [
            'target' => HttpAuthenticationEnv::class,
            'disabled' => !(bool)$extConf->get('http_authentication', 'envAccess'),
            'before' => [
                'typo3/cms-core/normalized-params-attribute',
            ],
            'after' => [
                'typo3/cms-frontend/timetracker',
            ],
        ],
        'christianfutterlieb/t3_http_auth/http-authentication-global' => [
            'target' => HttpAuthenticationGlobal::class,
            'disabled' => !(bool)$extConf->get('http_authentication', 'globalAccess'),
            'before' => [
                'typo3/cms-core/normalized-params-attribute',
            ],
            'after' => [
                'christianfutterlieb/t3_http_auth/http-authentication-env',
            ],
        ],
        'christianfutterlieb/t3_http_auth/http-authentication-site' => [
            'target' => HttpAuthenticationSite::class,
            'disabled' => !(bool)$extConf->get('http_authentication', 'siteBasedAccess'),
            'before' => [
                'typo3/cms-frontend/base-redirect-resolver',
                'typo3/cms-frontend/page-resolver',
                'typo3/cms-frontend/page-argument-validator',
                'typo3/cms-frontend/prepare-tsfe-rendering',
            ],
            'after' => [
                'typo3/cms-frontend/site',
            ],
        ],
        'christianfutterlieb/t3_http_auth/http-authentication-page' => [
            'target' => HttpAuthenticationPage::class,
            'disabled' => !(bool)$extConf->get('http_authentication', 'pageBasedAccess'),
            'before' => [
                'typo3/cms-frontend/prepare-tsfe-rendering',
            ],
            'after' => [
                'typo3/cms-frontend/page-resolver',
            ],
        ],
    ],
];
