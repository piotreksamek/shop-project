<?php

declare(strict_types=1);

namespace App\Application\Product\Message\Command;

use App\Shared\Messenger\CommandBus\Command;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;

class CreateProductCommand implements Command
{
    /** @param array<int, UploadedFile> $images */
    public function __construct(
        public Uuid $id,
        public string $name,
        public ?string $shortDescription,
        public string $description,
        public array $images,
    ) {}
}
