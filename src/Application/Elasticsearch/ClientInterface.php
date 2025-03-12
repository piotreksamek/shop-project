<?php

declare(strict_types=1);

namespace App\Application\Elasticsearch;

interface ClientInterface
{
    public function getDocument(string $index, array $body): array;
}
