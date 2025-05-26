<?php

declare(strict_types=1);

namespace ChristianFutterlieb\T3HttpAuth\Http\Authentication\Scheme;

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use ChristianFutterlieb\T3HttpAuth\Http\Authentication\Request as AuthenticationRequest;
use ChristianFutterlieb\T3HttpAuth\Http\Authentication\RequestInterface;
use ChristianFutterlieb\T3HttpAuth\Http\Authentication\SchemeInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Basic
 */
final class Basic implements SchemeInterface
{
    public function createAuthenticationRequest(ServerRequestInterface $request): RequestInterface
    {
        if (!$request->hasHeader('authorization')) {
            return new AuthenticationRequest();
        }

        $rawHeaderValue = $request->getHeaderLine('authorization');
        if (!str_starts_with($rawHeaderValue, 'Basic ')) {
            return new AuthenticationRequest();
        }

        $parts = explode(':', base64_decode(substr($rawHeaderValue, 6)), 2);
        $usernameFromHeader = ($parts[0] ?? null);
        $usernameFromHeader = $usernameFromHeader === '' ? null : $usernameFromHeader;
        $passwordFromHeader = ($parts[1] ?? null);
        $passwordFromHeader = $passwordFromHeader === '' ? null : $passwordFromHeader;

        return new AuthenticationRequest(
            identification: $usernameFromHeader,
            key: $passwordFromHeader,
        );
    }
}
