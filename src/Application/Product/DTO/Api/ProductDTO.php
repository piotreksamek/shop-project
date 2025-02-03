<?php

declare(strict_types=1);

namespace App\Application\Product\DTO\Api;

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
        #[Assert\Length(max: 50)]
        public string $name,
        #[OA\Property]
        #[Assert\NotBlank]
        #[Assert\Length(max: 2000)]
        public string $description,
        #[OA\Property]
        #[Assert\Length(max: 200)]
        public ?string $shortDescription = null,
        #[OA\Property]
        public array $images = [],
    ) {
    }
}
