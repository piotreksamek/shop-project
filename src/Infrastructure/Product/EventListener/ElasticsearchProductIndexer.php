<?php

declare(strict_types=1);

namespace App\Infrastructure\Product\EventListener;

use App\Domain\Product\Entity\Product;
use App\Domain\Product\Event\ProductCreated;
use App\Infrastructure\Elasticsearch\Client;
use App\Infrastructure\Elasticsearch\Index\ProductIndex;
use App\Infrastructure\Elasticsearch\Mapper\ProductMapper;
use App\Infrastructure\Product\ProductRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ElasticsearchProductIndexer
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly Client $client,
        private readonly LoggerInterface $logger
    ) {}

    public function __invoke(ProductCreated $productCreated): void
    {
        /** @var Product|null $product */
        $product = $this->productRepository->find($productCreated->productId);

        if (!$product) {
            $this->logger->info('Product not found');

            return;
        }

        $document = ProductMapper::toElasticsearch($product);

        try {
            $this->client->addDocument(ProductIndex::INDEX_NAME, $productCreated->productId->toRfc4122(), $document);
        } catch (\Exception $exception) {
            $this->logger->info($exception->getMessage());
        }
    }
}
