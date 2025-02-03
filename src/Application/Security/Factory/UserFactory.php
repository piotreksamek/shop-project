<?php

declare(strict_types=1);

namespace App\Application\Security\Factory;

use App\Application\Security\Message\RegisterUserCommand;
use App\Domain\Security\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function create(RegisterUserCommand $command): User
    {
        $user = new User(
            id: $command->id,
            email: $command->email,
            roles: ['ROLE_USER'],
        );

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $command->password));

        return $user;
    }
}
