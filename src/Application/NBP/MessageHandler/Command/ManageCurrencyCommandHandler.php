<?php

declare(strict_types=1);

namespace App\Application\NBP\MessageHandler\Command;

use App\Application\NBP\Factory\CurrencyFactory;
use App\Application\NBP\Message\Command\ManageCurrencyCommand;
use App\Application\NBP\Provider\CurrencyProvider;
use App\Domain\Interface\NBP\DoctrineCurrencyRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use InvalidArgumentException;

#[AsMessageHandler]
class ManageCurrencyCommandHandler
{
    public function __construct(
        private readonly CurrencyProvider $currencyProvider,
        private readonly CurrencyFactory $currencyFactory,
        private readonly DoctrineCurrencyRepositoryInterface $repository,
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
