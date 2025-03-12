<?php

declare(strict_types=1);

namespace App\Domain\Security\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use InvalidArgumentException;

#[Embeddable]
class Street
{
    public function __construct(
        #[Column(type: Types::STRING, length: 100, nullable: true)]
        private ?string $street = null,
    ) {
        if ($street) {
            self::validate($street);
        }
    }

    public static function validate(?string $street): void
    {
        if (strlen($street) > 100) {
            throw new InvalidArgumentException('Data is too long.');
        }
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }
}
