<?php

declare(strict_types=1);

namespace App\Application\Product\DTO\Api;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

class ProductDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 50)]
        public string $name,
        #[Assert\NotBlank]
        #[Assert\Length(max: 2000)]
        public string $description,
        #[Assert\Length(max: 200)]
        public ?string $shortDescription = null,
    ) {
    }
}
