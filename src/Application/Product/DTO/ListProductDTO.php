<?php

declare(strict_types=1);

namespace App\Application\Product\DTO;

class ListProductDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public array $images,
    ) {
    }
}
