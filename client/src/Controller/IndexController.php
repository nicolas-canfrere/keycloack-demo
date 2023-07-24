<?php

namespace App\Controller;

use App\Keycloack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public function __construct(
        private readonly Keycloack $keycloack
    ) {
    }

    #[Route('/', 'home')]
    public function __invoke(): Response
    {
        $jwt = $this->keycloack->getAccessToken('client_credentials');

        return (new JsonResponse())->setJson($jwt);
    }
}
