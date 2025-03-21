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
    #[Id]
    #[Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;

    #[Embedded(class: Address::class, columnPrefix: false)]
    private Address $address;

    public function __construct(
        #[Embedded(class: FirstName::class, columnPrefix: false)]
        private FirstName $firstName,
        #[Embedded(class: LastName::class, columnPrefix: false)]
        private LastName $lastName,
    ) {
        $this->id = Uuid::v7();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }
}
