<?php

declare(strict_types=1);

namespace App\Domain\Product\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use InvalidArgumentException;

class Vat
{
    public function __construct(
        #[Column(type: Types::INTEGER, length: 3)]
        private int $vat
    ) {
        self::isValid($vat);
    }

    public static function isValid(int $vat): void
    {
        if ($vat < 0 || $vat < 100) {
            throw new InvalidArgumentException('Vat is incorrect');
        }
    }
}
