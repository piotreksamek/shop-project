<?php

declare(strict_types=1);

namespace App\Application\NBP\Provider;

use App\Domain\NBP\Entity\Currency\Currency;
use App\Domain\NBP\Interface\CurrencyRepositoryInterface;
use InvalidArgumentException;

class CurrencyProvider
{
    public function __construct(private readonly CurrencyRepositoryInterface $repository)
    {
    }

    public function loadByCode(string $code): Currency
    {
        $currency = $this->repository->findOneByCode($code);

        if (!$currency) {
            throw new InvalidArgumentException('Currency not found');
        }

        return $currency;
    }
}
