<?php

declare(strict_types=1);

namespace App\Application\Security\Factory;

use App\Application\Security\Message\RegisterUserCommand;
use App\Domain\Security\Embeddable\FirstName;
use App\Domain\Security\Embeddable\LastName;
use App\Domain\Security\Entity\BaseInformation;
use App\Domain\Security\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function create(RegisterUserCommand $command): User
    {
        $baseInformation = $this->createBaseInformation($command);

        $user = new User(
            id: $command->id,
            email: $command->email,
            baseInformation: $baseInformation,
            roles: ['ROLE_USER'],
        );

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $command->password));

        return $user;
    }

    private function createBaseInformation(RegisterUserCommand $command): BaseInformation
    {
        return new BaseInformation(
            firstName: new FirstName($command->firstName),
            lastName: new LastName($command->lastName),
        );
    }
}
