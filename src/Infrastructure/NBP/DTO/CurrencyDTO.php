<?php

declare(strict_types=1);

namespace App\Infrastructure\NBP\DTO;

readonly class CurrencyDTO
{
    public function __construct(
        public string $table,
        public string $no,
        /** @var array<int, RatesDTO> */
        public array  $rates,
    ) {
    }
}
