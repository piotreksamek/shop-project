<?php

declare(strict_types=1);

namespace App\Application\Product\DTO;

class ListingFiltersDTO
{
    public function __construct(
        public string $id,
        public string $name,
    ) {}
}
