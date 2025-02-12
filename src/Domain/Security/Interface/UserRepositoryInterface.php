<?php

declare(strict_types=1);

namespace App\Domain\Security\Interface;

use App\Domain\Security\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function isEmailExist(string $email): bool;

    public function findOneByEmailVerifyToken(string $token): ?User;
}
