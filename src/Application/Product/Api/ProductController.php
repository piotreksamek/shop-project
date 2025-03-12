<?php

declare(strict_types=1);

namespace App\Application\Product\Api;

use App\Application\Elasticsearch\ClientInterface;
use App\Application\Product\DTO\Api\ProductDTO;
use App\Application\Product\DTO\ListingFiltersDTO;
use App\Application\Product\Message\Command\CreateProductCommand;
use App\Application\Product\Message\Query\GetProductQuery;
use App\Application\Product\Message\Query\GetProductsQuery;
use App\Shared\Api\Controller\AbstractApiController;
use App\Shared\Messenger\CommandBus\CommandBus;
use App\Shared\Messenger\QueryBus\Definition\CacheTagsDefinition;
use App\Shared\Messenger\QueryBus\Definition\QueryCacheDefinition;
use App\Shared\Messenger\QueryBus\QueryBus;
use OpenApi\Attributes as OA;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[AsController]
class ProductController extends AbstractApiController
{
    #[Route('/api/products/list', name: 'api_get_products', methods: [Request::METHOD_GET])]
    public function list(
        QueryBus $queryBus,
    ): JsonResponse {
        $result = $queryBus->handle(new GetProductsQuery());

        return $this->successData(
            'Lista produktów',
            $result
        );
    }

    #[Route('/api/products/{id}', name: 'api_get_product', methods: [Request::METHOD_GET])]
    public function getProduct(string $id, QueryBus $queryBus): JsonResponse
    {
        $result = $queryBus->handle(new GetProductQuery(Uuid::fromString($id)), QueryCacheDefinition::create()
            ->withExpirationTime(QueryCacheDefinition::EXPIRATION_TIME_HOUR)
            ->withTags([CacheTagsDefinition::getProductCacheTag($id)]));

        return $this->successData(
            'Produkt',
            $result
        );
    }

    #[Route('/api/products', name: 'api_post_products', methods: [Request::METHOD_POST])]
    public function createProduct(
        CommandBus $commandBus,
        #[MapRequestPayload] ProductDTO $dto,
        Request $request,
    ): JsonResponse {
        $id = Uuid::v7();

        try {
            $commandBus->dispatch(new CreateProductCommand(
                id: $id,
                name: $dto->name,
                shortDescription: $dto->shortDescription,
                description: $dto->description,
                images: $request->files->all('images'),
            ));
        } catch (HandlerFailedException $exception) {
            return $this->successKnownIssueMessage($exception);
        }

        return $this->successData(
            "Pomyślnie dodano produkt", [
                'id' => $id,
            ],
        );
    }
}
