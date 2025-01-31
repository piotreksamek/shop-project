<?php

declare(strict_types=1);

namespace App\Application\Product\MessageHandler\Command;

use App\Application\Product\Factory\ProductFactory;
use App\Application\Product\Message\Command\CreateProductCommand;
use App\Domain\Product\Interface\ProductRepositoryInterface;
use App\Shared\Messenger\QueryBus\Definition\CacheTagsDefinition;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[AsMessageHandler]
class CreateProductCommandHandler
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly TagAwareCacheInterface $cache,
    ) {
    }

    public function __invoke(CreateProductCommand $command)
    {
        $product = ProductFactory::create($command);

        $this->repository->save($product);

        $this->cache->invalidateTags([CacheTagsDefinition::getProductListCacheTag()]);
    }
}
