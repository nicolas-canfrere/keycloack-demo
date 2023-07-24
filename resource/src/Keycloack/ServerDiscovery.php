<?php

namespace App\Keycloack;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ServerDiscovery implements ServerDiscoveryInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $serverUrl,
        private readonly string $realm,
    ) {
    }

    public function discover(): AuthorizationServeurMetadata
    {
        $url = sprintf(
            '%s/realms/%s/.well-known/openid-configuration',
            $this->serverUrl,
            $this->realm
        );
        $response = $this->httpClient->request(
            'GET',
            $url
        );
        $response = $response->toArray();

        return AuthorizationServeurMetadata::fromArray($response);
    }
}
