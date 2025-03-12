<?php

declare(strict_types=1);

namespace App\Application\Common\DTO;

readonly class ImageDTO
{
    public function __construct(
        public string $path,
        public int $position,
    ) {
    }

    public static function fromArray(array $images): array
    {
        $results = [];

        foreach ($images as $image) {
            $results[] = new self(
                path: $image['path'],
                position: $image['position'],
            );
        }

        return $results;
    }
}