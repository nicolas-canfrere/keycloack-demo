<?php

namespace App\Keycloack;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ServerDiscoveryCacheDecorator implements ServerDiscoveryInterface
{
    public function __construct(
        private readonly ServerDiscoveryInterface $decorated,
        private readonly CacheInterface $cache,
    ) {
    }

    public function discover(): AuthorizationServeurMetadata
    {
        return $this->cache->get(
            'server_discovery',
            function (ItemInterface $item) {
                $item->expiresAfter(new \DateInterval('P1D'));
                return $this->decorated->discover();
            }
        );
    }
}
