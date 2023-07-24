<?php

namespace App\TokenExtraction;

use Symfony\Component\HttpFoundation\Request;

class AuthorizationHeaderTokenExtractor implements ExtractTokenInterface
{

    public function extract(Request $request): string|false
    {
        if (!$request->headers->has('Authorization')) {
            return false;
        }
        $authorizationHeader = $request->headers->get('Authorization');
        $headerParts = explode(' ', (string) $authorizationHeader);
        if (!(2 === count($headerParts) && 0 === strcasecmp($headerParts[0], 'Bearer'))) {
            return false;
        }

        return $headerParts[1];
    }
}
