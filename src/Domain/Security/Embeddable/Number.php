<?php

declare(strict_types=1);

namespace App\Domain\Security\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use InvalidArgumentException;

#[Embeddable]
class Number
{
    public function __construct(
        #[Column(type: Types::STRING, length: 10, nullable: true)]
        public ?string $number = null
    ) {
        if ($number) {
            self::validate($number);
        }
    }

    public static function validate(?string $number): void
    {
        if (strlen($number) > 10) {
            throw new InvalidArgumentException('Data is too long.');
        }
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }
}
