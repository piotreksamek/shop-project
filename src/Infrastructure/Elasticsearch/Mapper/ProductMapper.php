<?php

declare(strict_types=1);

namespace App\Infrastructure\Elasticsearch\Mapper;

use App\Application\Common\DTO\ImageDTO;
use App\Application\Product\DTO\ListProductDTO;
use App\Domain\Product\Entity\Product;

class ProductMapper
{
    public static function toElasticsearch(Product $product): array
    {
        return [
            'name' => $product->getName()->getName(),
            'shortDescription' => $product->getShortDescription()?->getShortDescription(),
            'description' => $product->getDescription()->getDescription(),
            'created_at' => $product->getCreatedAt()->format('Y-m-d\TH:i:s\Z'),
            'images' => self::getImages($product),
        ];
    }

    public static function fromElasticsearch(array $data): ListProductDTO
    {
        $source = $data['_source'];

        return new ListProductDTO(
            id: $data['_id'],
            name: $source['name'],
            images: ImageDTO::fromArray($source['images']),
        );
    }

    private static function getImages(Product $product): array
    {
        return array_map(function ($image) {
            return [
                'path' => $image->getImage()->getPath(),
                'position' => $image->getPosition(),
            ];
        }, $product->getImages()->toArray());
    }
}