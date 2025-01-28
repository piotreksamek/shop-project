<?php

namespace App\Product\Application\Message\Command;

use Symfony\Component\Uid\Uuid;

class CreateProductCommand
{
    public function __construct(
        public Uuid $id,
        public string $name,
        public string $description,
        public int $price,
    ) {
    }
}
