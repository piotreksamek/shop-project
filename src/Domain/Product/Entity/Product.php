<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity;

use App\Domain\Product\Embeddable\Description;
use App\Domain\Product\Embeddable\Money;
use App\Domain\Product\Embeddable\Name;
use App\Domain\Product\Embeddable\Price;
use App\Domain\Product\Embeddable\ShortDescription;
use App\Domain\Product\Event\ProductCreated;
use App\Domain\Security\Event\UserRegistered;
use App\Shared\Domain\Event\DomainEventTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity]
#[Table(name: 'product')]
#[HasLifecycleCallbacks]
class Product
{
    use DomainEventTrait;

    public const INDEX = 'product';

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[OneToMany(targetEntity: ProductImage::class, mappedBy: 'product', cascade: ['persist'], orphanRemoval: true)]
    private Collection $images;


    public function __construct(
        #[Id]
        #[Column(type: UuidType::NAME, unique: true)]
        private Uuid $id,
        #[Embedded(class: Name::class, columnPrefix: false)]
        private Name $name,
        #[Embedded(class: ShortDescription::class, columnPrefix: false)]
        private ?ShortDescription $shortDescription = null,
        #[Embedded(class: Description::class, columnPrefix: false)]
        private ?Description $description = null,
    ) {
        $this->images = new ArrayCollection();

        $this->apply(new ProductCreated($id));
    }

    #[PrePersist]
    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getShortDescription(): ?ShortDescription
    {
        return $this->shortDescription;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getDescription(): ?Description
    {
        return $this->description;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function addImage(ProductImage $image): void
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
        }

        $image->setProduct($this);
    }

    public function getImages(): Collection
    {
        return $this->images;
    }
}
