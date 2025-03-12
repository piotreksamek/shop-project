<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity;

use App\Domain\Product\Embeddable\Image;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity]
class ProductImage
{
    #[Id]
    #[Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;

    #[ManyToOne(targetEntity: Product::class, inversedBy: 'productImages')]
    private Product $product;

    public function __construct(
        #[Embedded(class: Image::class, columnPrefix: false)]
        private Image $image,
        #[Column(type: Types::INTEGER)]
        private int $position,
    ) {
        $this->id = Uuid::v7();
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
}
