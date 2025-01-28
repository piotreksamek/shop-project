<?php

declare(strict_types=1);

namespace App\Product\Application\MessageHandler\Command;

use App\Product\Application\Factory\ProductFactory;
use App\Product\Application\Message\Command\CreateProductCommand;
use App\Product\Domain\Interface\ProductRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[AsMessageHandler]
class CreateProductCommandHandler
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
//        private readonly ProductProvider $productProvider,
        private readonly TagAwareCacheInterface $cache,
    ) {
    }

    public function __invoke(CreateProductCommand $command)
    {
        $product = ProductFactory::create($command);

        $this->repository->save($product);

        $this->cache->invalidateTags(['app_product_list']);

        // invalidacja / usuwanie cachu.
    }
}
