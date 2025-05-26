<?php

declare(strict_types=1);

namespace ChristianFutterlieb\T3HttpAuth\Http\Middleware;

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use ChristianFutterlieb\T3HttpAuth\AccessSource\AccessSourceFactoryInterface;
use ChristianFutterlieb\T3HttpAuth\Http\Authentication\RequestMatcher;
use ChristianFutterlieb\T3HttpAuth\Http\Authentication\SchemeFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * AbstractHttpAuthentication
 */
abstract class AbstractHttpAuthentication implements MiddlewareInterface
{
    public const AUTHORIZED_ATTRIBUTE = 'http.authorized';

    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly RequestMatcher $requestMatcher,
        private readonly AccessSourceFactoryInterface $accessSourceFactory,
        private readonly SchemeFactoryInterface $schemeFactory,
    ) {
        unset($_ENV['EXT_HTTP_AUTHENTICATION_ACCESS_USERNAME'], $_SERVER['EXT_HTTP_AUTHENTICATION_ACCESS_USERNAME'], $_ENV['EXT_HTTP_AUTHENTICATION_ACCESS_PASSWORD'], $_SERVER['EXT_HTTP_AUTHENTICATION_ACCESS_PASSWORD']);
    }

    final public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Already authorized (on an above level)?
        if ($request->getAttribute(self::AUTHORIZED_ATTRIBUTE, false)) {
            return $handler->handle($request);
        }

        // Load access definitions
        $definitions = $this->accessSourceFactory->create(static::class, $request)->getDefinitions();

        if ($definitions === []) {
            return $handler->handle($request);
        }

        // Access definitions exist, now a authorization header must exist too
        if (!$request->hasHeader('authorization')) {
            return $this->createUnauthorizedResponse();
        }

        // Create an authentication request
        $authenticationRequest = $this->schemeFactory->createScheme($request)->createAuthenticationRequest($request);

        // Compare authentication request with definitions
        foreach ($definitions as $definition) {
            if ($this->requestMatcher->matchesDefinition($definition, $authenticationRequest)) {
                return $handler->handle(
                    $request->withAttribute(self::AUTHORIZED_ATTRIBUTE, true)
                );
            }
        }

        return $this->createUnauthorizedResponse();
    }

    private function createUnauthorizedResponse(): ResponseInterface
    {
        return $this->responseFactory->createResponse(401)
            ->withHeader('WWW-Authenticate', 'Basic realm="TYPO3 HTTP Authentication", charset="UTF-8"');
    }
}
