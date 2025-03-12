<?php

declare(strict_types=1);

namespace App\Infrastructure\Elasticsearch\Index;

class ProductIndex implements ElasticIndexInterface
{
    public const INDEX_NAME = 'product';

    /** @return array<string, mixed> */
    public static function getSettings(): array
    {
        return [
            'settings' => [
                'number_of_shards' => 3,
                'number_of_replicas' => 0,
                'analysis' => [
                    'analyzer' => [
                        'custom_analyzer' => [
                            'type' => 'custom',
                            'tokenizer' => 'standard',
                            'filter' => [
                                'lowercase',
                            ],
                        ],
                    ],
                ],
            ],
            'mappings' => [
                'properties' => [
                    'id' => [
                        'type' => 'keyword',
                    ],
                    'name' => [
                        'type' => 'text',
                    ],
                    'shortDescription' => [
                        'type' => 'text',
                    ],
                    'description' => [
                        'type' => 'text',
                    ],
                    'created_at' => [
                        'type' => 'date',
                    ],
                    'images' => [
                        'type' => 'nested',
                        'properties' => [
                            'path' => [
                                'type' => 'keyword',
                            ],
                            'position' => [
                                'type' => 'integer',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
