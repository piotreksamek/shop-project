<?php

declare(strict_types=1);

namespace App\Application\Product\MessageHandler\Query;

use App\Application\Product\DTO\ProductDTO;
use App\Application\Product\Message\Query\GetProductQuery;
use App\Domain\Product\Entity\Product;
use App\Domain\Product\Entity\ProductImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetProductQueryHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function __invoke(GetProductQuery $query): ProductDTO
    {
        $product = $this->getProduct($query->id->toBinary());

        $images = $this->getProductImages($query->id->toBinary());

        return ProductDTO::from($product, $images);
    }

    /** @return array<string, string> */
    private function getProduct(string $productId): array
    {
        $qbProduct = $this->entityManager->createQueryBuilder();

        return $qbProduct
            ->select('
            p.id,
            p.name.name AS name,
            p.shortDescription.shortDescription AS shortDescription,
            p.description.description AS description
        ')
            ->from(Product::class, 'p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $productId)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /** @return array<int, array<string, string>> */
    private function getProductImages(string $productId): array
    {
        $qb = $this->entityManager->createQueryBuilder();

        return $qb
            ->select('
            i.image.path as path,
            i.position
        ')
            ->from(ProductImage::class, 'i')
            ->leftJoin('i.product', 'p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $productId)
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
