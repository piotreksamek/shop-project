<?php

declare(strict_types=1);

namespace App\Domain\Security\Embeddable;

use Doctrine\ORM\Mapping\Embeddable;
use Doctrine\ORM\Mapping\Embedded;

#[Embeddable]
class Address
{
    public function __construct(
        #[Embedded(class: City::class, columnPrefix: false)]
        private City $city,
        #[Embedded(class: Street::class, columnPrefix: false)]
        private Street $street,
        #[Embedded(class: ApartmentNumber::class, columnPrefix: false)]
        private ApartmentNumber $apartmentNumber,
        #[Embedded(class: Number::class, columnPrefix: false)]
        private Number $number,
        #[Embedded(class: Province::class, columnPrefix: false)]
        private Province $province,
        #[Embedded(class: PostalCode::class, columnPrefix: false)]
        private PostalCode $postalCode,
    ) {
    }
}
