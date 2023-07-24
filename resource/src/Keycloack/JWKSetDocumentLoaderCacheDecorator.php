<?php

namespace App\Keycloack;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class JWKSetDocumentLoaderCacheDecorator implements JWKSetDocumentLoaderInterface
{
    public function __construct(
        private readonly JWKSetDocumentLoaderInterface $decorated,
        private readonly CacheInterface $cache,
    ) {
    }

    public function load(): array
    {
        return $this->cache->get(
            'server_certs',
            function (ItemInterface $item) {
                $item->expiresAfter(300);
                return $this->decorated->load();
            }
        );
    }
}
