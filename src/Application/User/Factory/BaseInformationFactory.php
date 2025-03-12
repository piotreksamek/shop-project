<?php

declare(strict_types=1);

namespace App\Application\User\Factory;

use App\Application\User\Message\UpdateUserCommand;
use App\Domain\Security\Embeddable\FirstName;
use App\Domain\Security\Embeddable\LastName;
use App\Domain\Security\Entity\BaseInformation;

class BaseInformationFactory
{
    public static function create(UpdateUserCommand $command): BaseInformation
    {
        $baseInformation = new BaseInformation(
            firstName: new FirstName($command->firstName),
            lastName: new LastName($command->lastName),
        );

        $baseInformation->setAddress(AddressFactory::createAddress($command));

        return $baseInformation;
    }
}
