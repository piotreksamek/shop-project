<?php

declare(strict_types=1);

namespace App\Application\Product\DTO;

use App\Application\Common\DTO\ImageDTO;
use Symfony\Component\Uid\Uuid;

readonly class ProductDTO
{
    /** @param ImageDTO[] $images */
    public function __construct(
        public Uuid $id,
        public string $name,
        public string $shortDescription,
        public string $description,
        public array $images,
    ) {}

    /**
     * @param array<string, mixed> $data
     *
     * @param array<int, array<string, string>> $images
     */
    public static function from(array $data, array $images): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            shortDescription: $data['shortDescription'],
            description: $data['description'],
            images: ImageDTO::fromArray($images),
        );
    }
}
