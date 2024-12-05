<?php

declare(strict_types=1);

namespace App\Domain\Entity\Product;

use App\Domain\Embeddable\Money;
use App\Domain\Entity\BaseEntity;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'product_price')]
class Price extends BaseEntity
{
    #[OneToOne(targetEntity: Product::class, inversedBy: 'price')]
    #[JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Product $product;

    public function __construct(
        #[Embedded(class: Money::class)]
        private Money $net,
        #[Embedded(class: Money::class)]
        private Money $gross,
    ) {
        parent::__construct();
    }

    public function getNet(): Money
    {
        return $this->net;
    }

    public function setNet(Money $net): void
    {
        $this->net = $net;
    }

    public function getGross(): Money
    {
        return $this->gross;
    }

    public function setGross(Money $gross): void
    {
        $this->gross = $gross;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
}
