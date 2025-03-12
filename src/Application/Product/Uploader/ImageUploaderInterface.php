<?php

declare (strict_types=1);

namespace App\Application\Product\Uploader;

use App\Application\Common\DTO\UploadImageDTO;

interface ImageUploaderInterface
{
    public function upload(UploadImageDTO $dto): string;
}
