<?php

declare(strict_types=1);

namespace App\Application\Product\Factory;

use App\Application\Common\DTO\UploadImageDTO;
use App\Application\Product\Uploader\ImageUploaderInterface;
use App\Domain\Product\Embeddable\Image;
use App\Domain\Product\Entity\Product;
use App\Domain\Product\Entity\ProductImage;
use Psr\Log\LoggerInterface;

class ProductImageFactory
{
    private const FILE_PATH = '/uploads/product';

    public function __construct(
        private readonly ImageUploaderInterface $imageUploader,
        private readonly LoggerInterface $logger
    ) {
    }

    public function createMany(Product $product, array $images): array
    {
        $path = sprintf('%s/%s', self::FILE_PATH, $product->getId()->toRfc4122());

        $uploadedImages = array_map(
            fn($image) => $this->imageUploader->upload(UploadImageDTO::from($image, $path)),
            $images
        );

        $result = [];

        $index = 1;

        foreach ($uploadedImages as $image) {
            $productImage = self::create($image, $index);

            $product->addImage($productImage);

            $index++;
        }

        return $result;
    }

    public static function create(string $path, int $position): ProductImage
    {
        return new ProductImage(
            image: new Image($path),
            position: $position
        );
    }
}
