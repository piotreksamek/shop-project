<?php

declare(strict_types=1);

namespace App\Product\Application\Api;

use App\Product\Application\DTO\Api\ProductDTO;
use App\Product\Application\Message\Command\CreateProductCommand;
use App\Shared\Api\Controller\AbstractApiController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[AsController]
class CreateProductController extends AbstractApiController
{
    #[OA\Post(
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
    #[Route('/api/products', name: 'api_post_products', methods: [Request::METHOD_POST])]
    public function __invoke(
        MessageBusInterface $commandBus,
        #[MapRequestPayload] ProductDTO $dto
    ): JsonResponse
    {
        $id = Uuid::v7();

        $commandBus->dispatch(new CreateProductCommand(
            id: $id,
            name: $dto->name,
            description: $dto->description,
            price: $dto->price,
        ));

        return new JsonResponse([]);
    }
}
