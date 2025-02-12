<?php

declare(strict_types=1);

namespace App\Application\User\DTO\Api;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UpdateUserDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 100)]
        public string $firstName,
        #[Assert\NotBlank]
        #[Assert\Length(max: 100)]
        public string $lastName,
        public ?AddressDTO $address = null,
    ) {
    }
}
