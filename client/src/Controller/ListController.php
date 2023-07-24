<?php

namespace App\Controller;

use App\Keycloack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ListController extends AbstractController
{
    public function __construct(
        private readonly Keycloack $keycloack,
        private readonly HttpClientInterface $httpClient,
    ) {
    }

    #[Route('/list', 'list')]
    public function __invoke(): Response
    {
        $jwt = \json_decode($this->keycloack->getAccessToken('client_credentials'), true);
        $response = $this->httpClient->request(
            'GET',
            'http://keycloack_demo_resource_server/api/list',
            [
                'auth_bearer' => $jwt['access_token']
            ]
        );

        return (new JsonResponse())->setJson($response->getContent());
    }
}
