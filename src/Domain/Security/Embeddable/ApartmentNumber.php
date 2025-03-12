<?php

declare(strict_types=1);

namespace App\Domain\Security\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use InvalidArgumentException;

#[Embeddable]
class ApartmentNumber
{
    public function __construct(
        #[Column(type: Types::STRING, length: 10, nullable: true)]
        private ?string $apartmentNumber = null
    ) {
        if ($apartmentNumber) {
            self::validate($apartmentNumber);
        }
    }

    public static function validate(string $apartmentNumber): void
    {
        if (strlen($apartmentNumber) > 10) {
            throw new InvalidArgumentException('Data is too long.');
        }
    }

    public function getApartmentNumber(): ?string
    {
        return $this->apartmentNumber;
    }
}
