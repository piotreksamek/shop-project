<?php

declare(strict_types=1);

namespace App\Application\NBP\CLI;

use App\Application\NBP\Message\Command\ManageCurrencyCommand;
use App\Infrastructure\NBP\Client;
use App\Infrastructure\NBP\Exception\ClientException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Cron running every hour
 */
#[AsCommand(name: self::NAME)]
class GetCurrenciesCommand extends Command
{
    use LockableTrait;

    const NAME = 'app:nbp:get-currencies';

    public function __construct(
        private readonly Client $client,
        private readonly LoggerInterface $currencyLogger,
        private readonly MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return Command::FAILURE;
        }

        try {
            $currencies = $this->client->getCurrencies();
        } catch (ClientException $clientException) {
            $this->currencyLogger->info($clientException->getMessage());

            return Command::FAILURE;
        }

        foreach ($currencies->rates as $currency) {
            $this->messageBus->dispatch((new ManageCurrencyCommand(
                $currency->currency,
                $currency->code,
                $currency->mid
            )));
        }


        return Command::SUCCESS;
    }
}
