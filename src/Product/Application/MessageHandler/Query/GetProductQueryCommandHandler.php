<?php

declare(strict_types=1);

namespace App\Product\Application\MessageHandler\Query;

use App\Product\Application\Message\Query\GetProductQuery;
use App\Product\Domain\Interface\ProductRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[AsMessageHandler]
class GetProductQueryCommandHandler
{
    public function __construct(
        private readonly TagAwareCacheInterface     $cache,
        private readonly ProductRepositoryInterface $repository, //EntityManager
    )
        //TagCacheAwareInterface
    {
    }

    public function __invoke(GetProductQuery $query)
    {
        $product = $this->cache->get('app_product_list', function (ItemInterface $item) {
            $product2 = $this->repository->findOneById(Uuid::fromString('019489a7-75ea-7480-87f4-fb988c3a1037'));

            dump('asd') ;
            $item->expiresAfter(3600);

            return $product2;
//            dd($product2);
//            $item->set(json_encode($product2));
//            $item->set(json_encode($product));
        });

        dd($product);

        return $product;
    }
}