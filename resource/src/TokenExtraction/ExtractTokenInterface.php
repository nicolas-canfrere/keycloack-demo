<?php

namespace App\TokenExtraction;

use Symfony\Component\HttpFoundation\Request;

interface ExtractTokenInterface
{
    public function extract(Request $request): string|false;
}
