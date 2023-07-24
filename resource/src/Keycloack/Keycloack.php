<?php

namespace App\Keycloack;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Keycloack
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly ServerDiscoveryInterface $serverDiscovery,
        private readonly string $clientId,
        private readonly string $clientSecret,
        private readonly string $serverUrl,
        private readonly string $realm,
    ) {
    }

    public function discover(): AuthorizationServeurMetadata
    {
        return $this->serverDiscovery->discover();
    }

    public function introspect(string $jwtToken)
    {
        $metadata = $this->discover();
        if (!$metadata->introspectionEndpoint) {
            throw new \Exception('Introspection not allowed');
        }
        $response = $this->httpClient->request(
            'POST',
            $metadata->introspectionEndpoint,
            [
                'body' => [
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'token' => $jwtToken
                ]
            ]
        );

        return $response->toArray();
    }

    public function getBaseTokenIntrospectionUrl(): string
    {
        return sprintf(
            '%s/protocol/openid-connect/token/introspect',
            $this->getBaseUrlWithRealm()
        );
    }

    protected function getBaseUrlWithRealm(): string
    {
        return sprintf(
            '%s/realms/%s',
            $this->serverUrl,
            $this->realm
        );
    }
}
