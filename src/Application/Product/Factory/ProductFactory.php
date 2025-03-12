<?php

declare(strict_types=1);

namespace App\Application\Product\Factory;

use App\Application\Product\Message\Command\CreateProductCommand;
use App\Domain\Product\Embeddable\Description;
use App\Domain\Product\Embeddable\Name;
use App\Domain\Product\Embeddable\ShortDescription;
use App\Domain\Product\Entity\Product;

class ProductFactory
{
    public static function create(CreateProductCommand $command): Product
    {
        return new Product(
            id: $command->id,
            name: new Name($command->name),
            shortDescription: $command->shortDescription ? new ShortDescription($command->shortDescription) : null,
            description: new Description($command->description),
        );
    }
}
