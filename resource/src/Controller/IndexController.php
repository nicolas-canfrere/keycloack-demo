<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/api/list', 'list')]
    public function __invoke(): Response
    {
        return new JsonResponse(
            [
                'data' => [
                    ['name' => 'name1'],
                    ['name' => 'name2'],
                    ['name' => 'name3'],
                    ['name' => 'name4'],
                ]
            ]
        );
    }
}
