<?php

namespace App\JWT;

use App\Keycloack\Keycloack;

class IntrospectValidator implements JWTValidatorInterface
{
    public function __construct(
        private readonly Keycloack $keycloack,
    ) {
    }

    public function validate(string $jwt): array
    {
        $introspectionResult = $this->keycloack->introspect($jwt);
        if (empty($introspectionResult['active'])) {
            throw new \Exception('jwt not active');
        }
        if (time() >= $introspectionResult['exp']) {
            throw new \Exception('jwt expired');
        }

        return $introspectionResult;
    }
}
