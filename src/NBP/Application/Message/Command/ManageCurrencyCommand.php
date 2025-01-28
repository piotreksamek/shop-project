<?php

declare(strict_types=1);

namespace App\NBP\Application\Message\Command;

readonly class ManageCurrencyCommand
{
    public function __construct(
        public string $currency,
        public string $code,
        public float $mid,
    ) {
    }
}
