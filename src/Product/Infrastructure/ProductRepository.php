<?php

declare(strict_types=1);

namespace App\Product\Infrastructure;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Interface\ProductRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $product): void
    {
        $em = $this->getEntityManager();

        $em->persist($product);
        $em->flush();
    }

    public function findOneById(Uuid $id): ?Product
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->andWhere('p.id = :id')
            ->setParameter('id', $id->toBinary())
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}
