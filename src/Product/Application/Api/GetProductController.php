<?php

declare(strict_types=1);

namespace App\Product\Application\Api;

use App\Product\Application\Message\Query\GetProductQuery;
use App\Shared\Api\Controller\AbstractApiController;
use App\Shared\Messenger\QueryBus\QueryBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[AsController]
class GetProductController extends AbstractApiController
{
    #[OA\Get(
        path: '/api/products',
//        description: 'Aktualizuje zamówienie',
//        requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/OrderDTO')),
//        tags: ['Order'],
//        responses: [
//            new OA\Response(
//                response: 200,
//                description: 'Zwraca zaktualizowane zamówienie',
//            ),
//        ]
    )]
    #[Route('/api/products', name: 'api_get_products', methods: [Request::METHOD_GET])]
    public function __invoke(QueryBus $queryBus)
    {
        $a = $queryBus->dispatch(new GetProductQuery('01946518-8184-784b-a6b4-43c02b558dac'));

        dd($a);
    }
}
