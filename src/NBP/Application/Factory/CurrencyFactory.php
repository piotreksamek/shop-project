<?php

declare(strict_types=1);

namespace App\NBP\Application\Factory;

use App\NBP\Application\Message\Command\ManageCurrencyCommand;
use App\NBP\Domain\Entity\Currency\Currency;

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
