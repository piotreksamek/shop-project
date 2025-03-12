<?php

declare(strict_types=1);

namespace App\Application\User\DTO\Api;

use App\Application\Common\Validator\PostalCode;
use App\Domain\Security\Embeddable\Address;
use Symfony\Component\Validator\Constraints as Assert;

readonly class AddressDTO
{
    public function __construct(
        #[Assert\Length(max: 100)]
        public ?string $street = null,
        #[Assert\Length(max: 10)]
        public ?string $number = null,
        #[Assert\Length(max: 10)]
        public ?string $apartmentNumber = null,
        #[Assert\Length(max: 100)]
        public ?string $city = null,
        #[Assert\Length(exactly: 6)]
        #[PostalCode]
        public ?string $postalCode = null,
        #[Assert\Length(max: 100)]
        public ?string $province = null,
    ) {}

    public static function from(Address $address): self
    {
        return new self(
            street: $address->getStreet()->getStreet(),
            number: $address->getNumber()->getNumber(),
            apartmentNumber: $address->getApartmentNumber()->getApartmentNumber(),
            city: $address->getCity()->getCity(),
            postalCode: $address->getPostalCode()->getPostalCode(),
            province: $address->getProvince()->getProvince(),
        );
    }
}
