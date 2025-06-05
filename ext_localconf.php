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

use ChristianFutterlieb\T3HttpAuth\Hook\DataHandlerHook;
use ChristianFutterlieb\T3HttpAuth\Hook\IconFactoryHook;
use TYPO3\CMS\Core\Imaging\IconFactory;

defined('TYPO3') || die();

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['http_authentication'] = DataHandlerHook::class;

// Icon overlay hook
// This can be removed as soon as support for TYPO3 <v13.0 is dropped
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][IconFactory::class]['overrideIconOverlay'][] = IconFactoryHook::class;
