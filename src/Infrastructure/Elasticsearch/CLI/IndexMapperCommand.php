<?php

declare(strict_types=1);

namespace App\Infrastructure\Elasticsearch\CLI;

use App\Infrastructure\Elasticsearch\Client;
use App\Infrastructure\Elasticsearch\Exception\ElasticException;
use App\Infrastructure\Elasticsearch\Index\ElasticIndexInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

#[AsCommand(name: self::COMMAND_NAME)]
class IndexMapperCommand extends Command
{
    use LockableTrait;
    private const COMMAND_NAME = 'elastic:index_mapper';

    private const INDEX_CLASS_CONST = 'INDEX_NAME';

    /** @param iterable<int, ElasticIndexInterface> $indexSettings */
    public function __construct(
        private readonly Client $client,
        #[AutowireIterator('app.elastic_index')]
        private readonly iterable $indexSettings,
        private readonly LoggerInterface $logger,
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
            foreach ($this->indexSettings as $indexSetting) {
                if (!$this->checkClassHasConstant($indexSetting)) {
                    continue;
                }

                if ($this->client->indexExists($indexSetting::INDEX_NAME)) {
                    continue;
                }

                $this->client->createIndex(
                    $indexSetting::INDEX_NAME,
                    $indexSetting::getSettings()
                );
            }
        } catch (ElasticException $exception) {
            $this->logger->info($exception->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function checkClassHasConstant(object $indexSetting): bool
    {
        $reflection = new \ReflectionClass($indexSetting);

        if (!$reflection->getConstant(self::INDEX_CLASS_CONST)) {
            $this->logger->info(sprintf("Class %s doesn't have INDEX_NAME constant.", $reflection->getName()));

            return false;
        }

        return true;
    }
}
