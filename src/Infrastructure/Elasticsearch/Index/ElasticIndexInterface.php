<?php

declare(strict_types=1);

namespace App\Infrastructure\Elasticsearch\Index;

interface ElasticIndexInterface
{
    /** @return array<string, mixed> */
    public static function getSettings(): array;
}
