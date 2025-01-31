<?php

declare(strict_types=1);

namespace App\Application\NBP\MessageHandler\Command;

use App\Application\NBP\Factory\CurrencyFactory;
use App\Application\NBP\Message\Command\ManageCurrencyCommand;
use App\Application\NBP\Provider\CurrencyProvider;
use App\Domain\NBP\Interface\CurrencyRepositoryInterface;
use InvalidArgumentException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ManageCurrencyCommandHandler
{
    public function __construct(
        private readonly CurrencyProvider            $currencyProvider,
        private readonly CurrencyFactory             $currencyFactory,
        private readonly CurrencyRepositoryInterface $repository,
    ) {
    }

    public function __invoke(ManageCurrencyCommand $command): void
    {
        try{
            $currency = $this->currencyProvider->loadByCode($command->code);

            if ($currency->getMid() !== $command->mid) {
                $currency->updateMid($command->mid);
            }
        } catch (InvalidArgumentException) {
            $currency = $this->currencyFactory->create($command);
        }

        $this->repository->save($currency);
    }
}
