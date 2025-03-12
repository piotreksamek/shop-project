<?php

declare(strict_types=1);

namespace App\Application\Elasticsearch;

interface ClientInterface
{
    /**
     * @param array<string, mixed> $query
     *
     * @return array<string, mixed>
     */
    public function getDocument(string $index, array $query): array;
}
