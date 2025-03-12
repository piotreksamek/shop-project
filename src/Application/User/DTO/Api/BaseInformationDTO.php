<?php

declare(strict_types=1);

namespace App\Application\User\DTO\Api;

use App\Domain\Security\Entity\BaseInformation;
use Symfony\Component\Validator\Constraints as Assert;

readonly class BaseInformationDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 100)]
        public string $firstName,
        #[Assert\NotBlank]
        #[Assert\Length(max: 100)]
        public string $lastName,
        public ?AddressDTO $address = null,
    ) {}

    public static function from(BaseInformation $baseInformation): self
    {
        return new self(
            firstName: $baseInformation->getFirstName()->getFirstName(),
            lastName: $baseInformation->getLastName()->getLastName(),
            address: AddressDTO::from($baseInformation->getAddress()),
        );
    }
}
