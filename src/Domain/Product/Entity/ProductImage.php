<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity;

use App\Domain\Product\Embeddable\Image;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity]
class ProductImage
{
    public function __construct(
        #[Id]
        #[Column(type: UuidType::NAME, unique: true)]
        private Uuid $id,
        #[Embedded(class: Image::class, columnPrefix: false)]
        private Image $image,
        #[Column(type: Types::BOOLEAN)]
        private bool $headImage,
    ) {
    }
}
