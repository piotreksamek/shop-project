<?php

declare(strict_types=1);

namespace App\Application\NBP\Provider;

use App\Domain\Entity\Currency\Currency;
use App\Domain\Interface\NBP\DoctrineCurrencyRepositoryInterface;
use InvalidArgumentException;

class CurrencyProvider
{
    public function __construct(private readonly DoctrineCurrencyRepositoryInterface $repository)
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
