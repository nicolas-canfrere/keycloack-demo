<?php

namespace App\Keycloack;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class JWKSetDocumentLoader implements JWKSetDocumentLoaderInterface
{
    public function __construct(
        private readonly ServerDiscoveryInterface $serverDiscovery,
        private readonly HttpClientInterface $httpClient,
    ) {
    }

    public function load(): array
    {
        $metadata = $this->serverDiscovery->discover();
        if (!$metadata->jwksUri) {
            throw new \Exception('jwks_uri not defined');
        }
        $response = $this->httpClient->request(
            'GET',
            $metadata->jwksUri
        );

        return $response->toArray();
    }
}
