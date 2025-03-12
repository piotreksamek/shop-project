<?php

declare(strict_types=1);

namespace App\Infrastructure\Product\Uploader;

use App\Application\Common\DTO\UploadImageDTO;
use App\Application\Product\Uploader\ImageUploaderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class LocalImageUploader implements ImageUploaderInterface
{
    public function __construct(
        #[Autowire('%app.file_upload_path%')]
        private readonly string $uploadPath
    ) {
    }

    public function upload(UploadImageDTO $dto): string
    {
        $path = sprintf('%s/%s', $this->uploadPath, $dto->path);

        $image = $dto->image;

        $fileName = uniqid('image_', true) . '.' . $image->guessExtension();

        $image->move($path, $fileName);

        return sprintf('%s/%s', $dto->path, $fileName);
    }
}
