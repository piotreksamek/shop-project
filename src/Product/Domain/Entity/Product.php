<?php

declare(strict_types=1);

namespace App\Product\Domain\Entity;

use App\Product\Domain\Embeddable\Description;
use App\Product\Domain\Embeddable\Name;
use App\Product\Domain\Embeddable\Price;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity]
#[Table(name: 'product')]
class Product
{
    public function __construct(
        #[Id]
        #[Column(type: UuidType::NAME, unique: true)]
        private Uuid $id,
        #[Embedded(class: Name::class, columnPrefix: false)]
        private Name $name,
        //shortdescription
        #[Embedded(class: Description::class, columnPrefix: false)]
        private Description $description,
        // firma
        // okres realizacji
        //headimage
        #[Embedded(class: Price::class, columnPrefix: false)]
        private Price $price,
    ) {
    }
}
