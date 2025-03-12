<?php

declare(strict_types=1);

namespace App\Application\Product\MessageHandler\Command;

use App\Application\Product\Factory\ProductFactory;
use App\Application\Product\Factory\ProductImageFactory;
use App\Application\Product\Message\Command\CreateProductCommand;
use App\Domain\Product\Interface\ProductRepositoryInterface;
use App\Shared\Domain\Event\SymfonyDomainEventBus;
use App\Shared\Messenger\QueryBus\Definition\CacheTagsDefinition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[AsMessageHandler]
class CreateProductCommandHandler
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly TagAwareCacheInterface $cache,
        private readonly SymfonyDomainEventBus $domainEventBus,
        private readonly ProductImageFactory $productImageFactory,
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(CreateProductCommand $command): void
    {
        $this->entityManager->beginTransaction();

        try {
            $product = ProductFactory::create($command);

            $this->productImageFactory->createMany($product, $command->images);

            $this->repository->save($product);

            $productEventStream = $product->getUncommittedEvents();

            $this->domainEventBus->dispatchStream($productEventStream);

            $this->cache->invalidateTags([CacheTagsDefinition::getProductListCacheTag()]);
        } catch (\Exception $e) {
            $this->entityManager->rollback();

            throw $e;
        }

        $this->entityManager->commit();
    }
}
