<?php

declare(strict_types=1);

namespace App\NBP\Application\Provider;

use App\NBP\Domain\Entity\Currency\Currency;
use App\NBP\Domain\Interface\CurrencyRepositoryInterface;
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
