<?php

namespace App\JWT;

interface JWTValidatorInterface
{
    public function validate(string $jwt): array;
}
