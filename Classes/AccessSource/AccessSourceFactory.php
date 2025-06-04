<?php

declare(strict_types=1);

namespace ChristianFutterlieb\T3HttpAuth\AccessSource;

/*
 * Copyright by Christian Futterlieb
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use ChristianFutterlieb\T3HttpAuth\Event\AccessSourceObjectCreatedEvent;
use ChristianFutterlieb\T3HttpAuth\Http\Middleware\HttpAuthenticationEnv;
use ChristianFutterlieb\T3HttpAuth\Http\Middleware\HttpAuthenticationGlobal;
use ChristianFutterlieb\T3HttpAuth\Http\Middleware\HttpAuthenticationPage;
use ChristianFutterlieb\T3HttpAuth\Http\Middleware\HttpAuthenticationSite;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Routing\PageArguments;
use TYPO3\CMS\Core\Site\Entity\Site;

/**
 * AccessSourceFactory
 */
final class AccessSourceFactory implements AccessSourceFactoryInterface
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public function create(string $context, ServerRequestInterface $request): AccessSourceInterface
    {
        $accessSource = match ($context) {
            HttpAuthenticationEnv::class => new Environment(),
            HttpAuthenticationGlobal::class => new Typo3ConfVars(),
            HttpAuthenticationSite::class => $this->createAccessSourceSiteSettings($request),
            HttpAuthenticationPage::class => $this->createAccessSourcePage($request),
            default => new class() implements AccessSourceInterface {
                public function getDefinitions(): array
                {
                    return [];
                }
            },
        };

        $event = new AccessSourceObjectCreatedEvent($context, $request, $accessSource);
        return $this->eventDispatcher->dispatch($event)->getAccessSource();
    }

    private function createAccessSourceSiteSettings(ServerRequestInterface $request): SiteSettings
    {
        return new SiteSettings(
            $this->getSiteFromRequest($request)
        );
    }

    private function createAccessSourcePage(ServerRequestInterface $request): Page
    {
        return new Page(
            $this->getPageArgumentsFromRequest($request)->getPageId()
        );
    }

    private function getSiteFromRequest(ServerRequestInterface $request): Site
    {
        // This attribute is set in \TYPO3\CMS\Frontend\Middleware\SiteResolver
        return $request->getAttribute('site');
    }

    private function getPageArgumentsFromRequest(ServerRequestInterface $request): PageArguments
    {
        // This attribute is set in \TYPO3\CMS\Frontend\Middleware\PageResolver
        return $request->getAttribute('routing');
    }
}
