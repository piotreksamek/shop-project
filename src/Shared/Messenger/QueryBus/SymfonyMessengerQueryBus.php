<?php

declare(strict_types=1);

namespace App\Shared\Messenger\QueryBus;

use App\Shared\Messenger\QueryBus\Definition\QueryCacheDefinition;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

final class SymfonyMessengerQueryBus implements QueryBus
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(
        MessageBusInterface $queryBus,
        private TagAwareCacheInterface $applicationQueryCachePool,
    ) {
        $this->messageBus = $queryBus;
    }

    public function handle(Query $query, ?QueryCacheDefinition $queryCacheDefinition = null): mixed
    {
        if (!$queryCacheDefinition) {
            return $this->handleQuery($query);
        }

        $cacheKey = $this->generateCacheKey($query);

        $tags = $queryCacheDefinition->getTags();

        return $this->applicationQueryCachePool->get(
            $cacheKey,
            function (ItemInterface $item) use ($query, $queryCacheDefinition, $tags) {
                $item->expiresAfter($queryCacheDefinition->getExpirationTime());
                if (!empty($tags)) {
                    $item->tag($tags);
                }

                return $this->handleQuery($query);
            },
        );
    }

    public function cacheExist(Query $query): bool
    {
        $cacheKey = $this->generateCacheKey($query);
        /** @var TagAwareAdapter $cacheAdapter */
        $cacheAdapter = $this->applicationQueryCachePool;

        return $cacheAdapter->hasItem($cacheKey);
    }

    private function generateCacheKey(Query $query): string
    {
        return md5(serialize($query));
    }
}
