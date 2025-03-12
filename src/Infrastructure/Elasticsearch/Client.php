<?php

declare(strict_types=1);

namespace App\Infrastructure\Elasticsearch;

use App\Application\Elasticsearch\ClientInterface;
use App\Infrastructure\Elasticsearch\Exception\ElasticException;
use Elastic\Elasticsearch\ClientBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class Client implements ClientInterface
{
    private $client;

    public function __construct(
        #[Autowire('%app.elasticsearch_host%')]
        private readonly string $elasticHost,
        #[Autowire('%app.elasticsearch_api_key%')]
        private readonly string $apiKey,
        private readonly LoggerInterface $logger,
    ) {
        $this->client = ClientBuilder::create()
            ->setHosts([$elasticHost])
            ->setApiKey($apiKey)
            ->build();
    }

    /**
     * @param array $params Parametry zapytania
     * @return array Wynik zapytania
     */
    public function search(array $params): array
    {
        try {
            $response = $this->client->search($params);

            return $response->asArray()['hits'];
        } catch (\Exception $e) {
            $this->logger->error('Elasticsearch query failed: ' . $e->getMessage());

            return [];
        }
    }

    public function createIndex(string $index, array $params): void
    {
        $params = [
            'index' => $index,
            'body' => $params,
        ];

        try {
            $this->client->indices()->create($params);

        } catch (\Exception $exception) {
            throw new ElasticException($exception->getMessage());
        }
    }

    public function indexExists(string $indexName): bool
    {
        $params = [
            'index' => $indexName,
        ];

        try {
            $response = $this->client->indices()->exists($params);

            return $response->asBool();
        } catch (\Exception $exception) {
            throw new ElasticException($exception->getMessage());
        }
    }

    public function addDocument(string $index, string $id, array $document): array
    {
        $params = [
            'index' => $index,
            'id' => $id,
            'body'  => $document
        ];

        try {
            $response = $this->client->index($params);

            return $response->asArray();
        } catch (\Exception $e) {
            throw new ElasticException($e->getMessage());
        }
    }

    public function getDocument(string $index, array $query): array
    {
        $params = [
            'index' => $index,
            'body' => $query,
        ];

        try {
            $response = $this->client->search($params);

            return $response->asArray();
        } catch (\Exception $e) {
            throw new ElasticException($e->getMessage());
        }
    }
}
