<?php

declare(strict_types=1);

namespace App\Application\Product\MessageHandler\Query;

use App\Application\Product\Message\Query\GetProductsQuery;
use App\Domain\Product\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetProductsQueryHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(GetProductsQuery $query)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb
            ->select('p')
            ->from(Product::class, 'p')
            ;

        return $qb->getQuery()->getArrayResult();
    }
}
