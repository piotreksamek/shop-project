<?php

declare(strict_types=1);

namespace App\NBP\Domain\Interface;

use App\NBP\Domain\Entity\Currency\Currency;

interface CurrencyRepositoryInterface
{
    public function save(Currency $currency): void;

    public function findOneByCode(string $code): ?Currency;
}
