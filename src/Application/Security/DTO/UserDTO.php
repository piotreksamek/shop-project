<?php

declare(strict_types=1);

namespace App\Application\Security\DTO;

readonly class UserDTO
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}
