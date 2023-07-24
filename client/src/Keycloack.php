<?php

namespace App;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Keycloack
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $clientId,
        private readonly string $clientSecret,
        private readonly string $serverUrl,
        private readonly string $realm,
    ) {
    }

    public function getAccessToken(string $grantType): string
    {
        $response = $this->httpClient->request(
            'POST',
            $this->getBaseAccessTokenUrl(),
            [
                'body' => [
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'grant_type' => $grantType
                ]
            ]
        );

        return $response->getContent();
    }

    protected function getBaseUrlWithRealm(): string
    {
        return sprintf(
            '%s/realms/%s',
            $this->serverUrl,
            $this->realm
        );
    }

    public function getBaseAccessTokenUrl(): string
    {
        return sprintf(
            '%s/protocol/openid-connect/token',
            $this->getBaseUrlWithRealm()
        );
    }
}
