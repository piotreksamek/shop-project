<?php

declare(strict_types=1);

namespace App\Domain\Security\Entity;

use App\Domain\Security\Embeddable\Address;
use App\Domain\Security\Embeddable\FirstName;
use App\Domain\Security\Embeddable\LastName;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity]
#[Table(name: 'user_base_information')]
class BaseInformation
{
    public function __construct(
        #[Id]
        #[Column(type: UuidType::NAME, unique: true)]
        private Uuid $id,
        #[Embedded(class: FirstName::class, columnPrefix: false)]
        private FirstName $firstName,
        #[Embedded(class: LastName::class, columnPrefix: false)]
        private LastName $lastName,
        #[Embedded(class: Address::class, columnPrefix: false)]
        private Address $address,
    ) {
    }
}
