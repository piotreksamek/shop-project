<?php

declare(strict_types=1);

namespace App\Infrastructure\Elasticsearch\Index;

interface ElasticIndexInterface
{
    public static function getSettings(): array;
}
