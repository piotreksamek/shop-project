<?php

declare(strict_types=1);

namespace App\Domain\Security\Interface;

use App\Domain\Security\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
}
//curl -X POST -H "Content-Type: application/json" http://0.0.0.0:8080/api/login_check -d '{"username":"piotrek@asd.pl","password":"Dupa123!"}'