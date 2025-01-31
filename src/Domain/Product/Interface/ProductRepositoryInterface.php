<?php

declare(strict_types=1);

namespace App\Domain\Product\Interface;

use App\Domain\Product\Entity\Product;
use Symfony\Component\Uid\Uuid;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;

    public function findOneById(Uuid $id): ?Product;
}
