<?php

namespace App\Keycloack;

/**
 * voir https://datatracker.ietf.org/doc/html/rfc8414
 */
class AuthorizationServeurMetadata
{
    public function __construct(
        public readonly string $issuer,
        public readonly string $authorizationEndpoint,
        public readonly string $tokenEndpoint,
        public readonly array $responseTypesSupported,
        public readonly ?array $responseModesSupported = null,
        public readonly ?array $grantTypesSupported = null,
        public readonly ?array $scopesSupported = null,
        public readonly ?array $tokenEndpointAuthMethodsSupported = null,
        public readonly ?string $jwksUri = null,
        public readonly ?string $registrationEndpoint = null,
        public readonly ?string $revocationEndpoint = null,
        public readonly ?string $introspectionEndpoint = null,
    ) {
    }

    public static function fromArray(array $data): AuthorizationServeurMetadata
    {
        return new static(
            $data['issuer'],
            $data['authorization_endpoint'],
            $data['token_endpoint'],
            $data['response_types_supported'],
            $data['response_modes_supported'] ?? null,
            $data['grant_types_supported'] ?? null,
            $data['scopes_supported'] ?? null,
            $data['token_endpoint_auth_methods_supported'] ?? null,
            $data['jwks_uri'] ?? null,
            $data['registration_endpoint'] ?? null,
            $data['revocation_endpoint'] ?? null,
            $data['introspection_endpoint'] ?? null,
        );
    }
}
