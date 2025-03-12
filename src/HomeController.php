<?php

declare(strict_types=1);

namespace App;

use App\Infrastructure\Elasticsearch\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function __invoke(Client $client): JsonResponse
    {
        return new JsonResponse();
    }
}
