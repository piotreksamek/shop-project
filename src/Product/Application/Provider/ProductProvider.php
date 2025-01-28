<?php

declare(strict_types=1);

namespace App\Product\Application\Provider;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Interface\ProductRepositoryInterface;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

class ProductProvider
{
    public function __construct(private readonly ProductRepositoryInterface $repository)
    {
    }

    public function loadById(Uuid $id): Product
    {
        $product = $this->repository->findOneById($id);

        if (!$product) {
            throw new InvalidArgumentException(sprintf('Product with id "%s" could not be found.', $id));
        }

        return $product;
    }
}
