<?php

declare(strict_types=1);

namespace App\Domain\Entity\Product;

use App\Domain\Entity\BaseEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'product')]
class Product extends BaseEntity
{
    public function __construct(
        #[Column(type: Types::STRING, length: 255)]
        private string $name,
        #[Embedded(class: Price::class)]
        private Price  $price,
    ) {
        parent::__construct();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
}