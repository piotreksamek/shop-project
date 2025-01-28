<?php

declare(strict_types=1);

namespace App\Product\Application\DTO\Api;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(
    schema: 'product',
)]
class ProductDTO
{
    public function __construct(
        #[OA\Property]
        #[Assert\NotBlank]
        public string $name,
        #[OA\Property]
        public string $description,
        #[Assert\NotBlank]
        #[OA\Property]
        public int $price,
    ) {
    }
}
