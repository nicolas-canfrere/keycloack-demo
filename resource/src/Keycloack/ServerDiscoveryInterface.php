<?php

namespace App\Keycloack;

interface ServerDiscoveryInterface
{
    public function discover(): AuthorizationServeurMetadata;
}
