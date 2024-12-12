<?php

declare(strict_types=1);

namespace App\Domain\Interface\NBP;

use App\Domain\Entity\Currency\Currency;

interface DoctrineCurrencyRepositoryInterface
{
    public function save(Currency $currency): void;

    public function findOneByCode(string $code): ?Currency;
}
