<?php

declare(strict_types=1);

namespace App\Application\NBP\Factory;

use App\Application\NBP\Message\Command\ManageCurrencyCommand;
use App\Domain\Entity\Currency\Currency;

class CurrencyFactory
{
    public function create(ManageCurrencyCommand $command): Currency
    {
        return new Currency(
            name: $command->currency,
            code: $command->code,
            mid: $command->mid,
        );
    }
}
