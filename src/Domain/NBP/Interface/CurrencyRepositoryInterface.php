<?php

declare(strict_types=1);

namespace App\Domain\NBP\Interface;

use App\Domain\NBP\Entity\Currency\Currency;

interface CurrencyRepositoryInterface
{
    public function save(Currency $currency): void;

    public function findOneByCode(string $code): ?Currency;
}
