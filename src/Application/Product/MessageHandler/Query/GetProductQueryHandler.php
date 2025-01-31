<?php

declare(strict_types=1);

namespace App\Application\Product\MessageHandler\Query;

use App\Application\Product\Message\Query\GetProductQuery;
use App\Domain\Product\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetProductQueryHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(GetProductQuery $query)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb
            ->select('p')
            ->from(Product::class, 'p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $query->id->toBinary())
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}