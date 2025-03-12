<?php

declare(strict_types=1);

namespace App\Infrastructure\Elasticsearch;

use App\Application\Elasticsearch\ClientInterface;
use App\Infrastructure\Elasticsearch\Exception\ElasticException;
use Elastic\Elasticsearch\ClientBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Elastic\Elasticsearch\Client as ElasticsearchClient;

class Client implements ClientInterface
{
    private ElasticsearchClient $client;

    public function __construct(
        #[Autowire('%app.elasticsearch_host%')]
        private readonly string $elasticHost,
        #[Autowire('%app.elasticsearch_api_key%')]
        private readonly string $apiKey,
        private readonly LoggerInterface $logger,
    ) {
        $this->client = ClientBuilder::create()
            ->setHosts([$this->elasticHost])
            ->setApiKey($this->apiKey)
            ->build()
        ;
    }

    /**
     * @param array<string, mixed> $params
     *
     * @return array<string, mixed>
     */
    public function search(array $params): array
    {
        try {
            $response = $this->client->search($params);

            return $response->asArray()['hits'];
        } catch (\Exception $e) {
            $this->logger->error('Elasticsearch query failed: '.$e->getMessage());

            return [];
        }
    }

    /** @param array<string, mixed> $params */
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

    /**
     * @param array<string, mixed> $document
     *
     * @return array<string, mixed>
     */
    public function addDocument(string $index, string $id, array $document): array
    {
        $params = [
            'index' => $index,
            'id' => $id,
            'body' => $document,
        ];

        try {
            $response = $this->client->index($params);

            return $response->asArray();
        } catch (\Exception $e) {
            throw new ElasticException($e->getMessage());
        }
    }

    /**
     * @param array<string, mixed> $query
     *
     * @return array<string, mixed>
     */
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
