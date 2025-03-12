<?php

declare(strict_types=1);

namespace App\Application\Product\MessageHandler\Query;

use App\Application\Elasticsearch\ClientInterface;
use App\Application\Product\Message\Query\GetProductsQuery;
use App\Domain\Product\Entity\Product;
use App\Infrastructure\Elasticsearch\Mapper\ProductMapper;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetProductsQueryHandler
{
    public function __construct(
        private readonly ClientInterface $client,
    ) {
    }

    public function __invoke(GetProductsQuery $query): array
    {
        $body = [
            'query' => [
                'bool' => [
                    'must' => [],
                    'filter' => []
                ]
            ]
        ];

        $response = $this->client->getDocument(Product::INDEX, $body);

        $results = [];

        foreach ($response['hits']['hits'] as $product) {
//            dd($product);
            $results[] = ProductMapper::fromElasticsearch($product);
        }

        return $results;
    }
}
