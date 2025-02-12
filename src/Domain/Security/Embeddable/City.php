<?php

declare(strict_types=1);

namespace App\Domain\Security\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use InvalidArgumentException;

#[Embeddable]
class City
{
    public function __construct(
        #[Column(type: Types::STRING, length: 100, nullable: true)]
        public ?string $city = null
    ) {
        if ($city) {
            self::validate($city);
        }
    }

    public static function validate(?string $city): void
    {
        if (strlen($city) > 100) {
            throw new InvalidArgumentException('Data is too long.');
        }
    }
}
