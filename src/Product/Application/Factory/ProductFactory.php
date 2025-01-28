<?php

declare(strict_types=1);

namespace App\Product\Application\Factory;

use App\Product\Application\Message\Command\CreateProductCommand;
use App\Product\Domain\Embeddable\Description;
use App\Product\Domain\Embeddable\Name;
use App\Product\Domain\Embeddable\Price;
use App\Product\Domain\Entity\Product;

class ProductFactory
{
    public static function create(CreateProductCommand $command): Product
    {
        return new Product(
            id: $command->id,
            name: new Name($command->name),
            description: new Description($command->description),
            price: new Price($command->price, 'PLN'),
        );
    }
}
