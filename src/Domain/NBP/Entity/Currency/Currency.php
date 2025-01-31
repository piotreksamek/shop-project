<?php

declare(strict_types=1);

namespace App\Domain\NBP\Entity\Currency;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity]
#[Table(name: 'currency')]
class Currency
{
    #[Id]
    #[Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;

    public function __construct(
        #[Column(type: Types::STRING)]
        private string $name,
        #[Column(type: Types::STRING)]
        private string $code,
        #[Column(type: Types::FLOAT)]
        private float $mid,
    ) {
        $this->id = Uuid::v7();
    }

    public function updateMid(float $mid): void
    {
        $this->mid = $mid;
    }

    public function getMid(): float
    {
        return $this->mid;
    }
}
