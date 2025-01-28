<?php

declare(strict_types=1);

namespace App\NBP\Application\MessageHandler\Command;

use App\NBP\Application\Factory\CurrencyFactory;
use App\NBP\Application\Message\Command\ManageCurrencyCommand;
use App\NBP\Application\Provider\CurrencyProvider;
use App\NBP\Domain\Interface\CurrencyRepositoryInterface;
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
