<?php

declare(strict_types=1);

namespace App\Application\User\Factory;

use App\Application\User\Message\UpdateUserCommand;
use App\Domain\Security\Embeddable\Address;
use App\Domain\Security\Embeddable\ApartmentNumber;
use App\Domain\Security\Embeddable\City;
use App\Domain\Security\Embeddable\FirstName;
use App\Domain\Security\Embeddable\LastName;
use App\Domain\Security\Embeddable\Number;
use App\Domain\Security\Embeddable\PostalCode;
use App\Domain\Security\Embeddable\Province;
use App\Domain\Security\Embeddable\Street;
use App\Domain\Security\Entity\BaseInformation;
use Symfony\Component\Uid\Uuid;

class BaseInformationFactory
{
    public static function create(UpdateUserCommand $command): BaseInformation
    {
        return new BaseInformation(
            id: Uuid::v7(),
            firstName: new FirstName($command->firstName),
            lastName: new LastName($command->lastName),
            address: new Address(
                city: new City($command->city),
                street: new Street($command->street),
                apartmentNumber: new ApartmentNumber($command->apartmentNumber),
                number: new Number($command->number),
                province: new Province($command->province),
                postalCode: new PostalCode($command->postalCode)
            )
        );
    }
}
