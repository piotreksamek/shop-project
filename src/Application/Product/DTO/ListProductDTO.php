<?php

declare(strict_types=1);

namespace App\Application\Product\DTO;

use App\Application\Common\DTO\ImageDTO;

class ListProductDTO
{
    /** @param ImageDTO[] $images */
    public function __construct(
        public string $id,
        public string $name,
        public array $images,
    ) {}
}
