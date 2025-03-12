<?php

declare(strict_types=1);

namespace App\Application\Common\DTO;

use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class UploadImageDTO
{
    public function __construct(
        public UploadedFile $image,
        public string $path,
    ) {}

    public static function from(UploadedFile $image, string $path): self
    {
        return new self(
            image: $image,
            path: $path,
        );
    }
}
