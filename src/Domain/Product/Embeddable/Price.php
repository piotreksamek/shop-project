<?php

declare(strict_types=1);

namespace App\Domain\Product\Embeddable;

use Doctrine\ORM\Mapping\Embeddable;
use Doctrine\ORM\Mapping\Embedded;

#[Embeddable]
class Price
{
    public function __construct(
        #[Embedded(class: Money::class)]
        private Money $net,
        #[Embedded(class: Money::class)]
        private Money $gross,
        #[Embedded(class: Vat::class)]
        private Vat $vat,
    ) {}

    public function getNet(): Money
    {
        return $this->net;
    }

    public function getGross(): Money
    {
        return $this->gross;
    }

    public function getVat(): Vat
    {
        return $this->vat;
    }
}
