<?php

declare(strict_types=1);

namespace App\Domain\Product\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use InvalidArgumentException;

class Money
{
    public function __construct(
        #[Column(type: Types::INTEGER)]
        private int $price,
        #[Column(type: Types::STRING, length: 3)]
        private string $currency,
    ) {
        if (strlen($currency) > 3) {
            throw new InvalidArgumentException('Currency must be 3 characters long');
        }
    }
}
