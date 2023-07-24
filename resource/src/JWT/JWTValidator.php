<?php

namespace App\JWT;

use App\Keycloack\JWKSetDocumentLoaderInterface;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Psr\Log\LoggerInterface;

class JWTValidator implements JWTValidatorInterface
{
    public function __construct(
        private readonly JWKSetDocumentLoaderInterface $JWKSetDocumentLoader,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function validate(string $jwt): array
    {
        $jwks = $this->JWKSetDocumentLoader->load();
        $this->logger->debug('jwks', $jwks);
        $this->logger->debug('jwt', [$jwt]);

        $decoded = JWT::decode($jwt, JWK::parseKeySet($jwks));

        return [
            'sub' => $decoded->sub,
            'data' => $decoded,
        ];
    }
}
