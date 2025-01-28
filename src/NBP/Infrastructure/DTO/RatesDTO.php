<?php

declare(strict_types=1);

namespace App\NBP\Infrastructure\DTO;

readonly class RatesDTO
{
    public function __construct(
        public string $currency,
        public string $code,
        public float  $mid,
    ) {
    }
}
