<?php

namespace App\Keycloack;

interface JWKSetDocumentLoaderInterface
{
    public function load(): array;
}
