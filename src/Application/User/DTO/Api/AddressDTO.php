<?php

declare(strict_types=1);

namespace App\Application\User\DTO\Api;

use App\Application\Common\Validator\PostalCode;
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
        #[Assert\Length(max: 100)]
        public ?string $country = null,
    ) {
    }
}
