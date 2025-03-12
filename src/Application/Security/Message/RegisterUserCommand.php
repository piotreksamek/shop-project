<?php

declare(strict_types=1);

namespace App\Application\Security\Message;

use App\Shared\Messenger\CommandBus\Command;
use Symfony\Component\Uid\Uuid;

readonly class RegisterUserCommand implements Command
{
    public function __construct(
        public Uuid $id,
        public string $email,
        public string $password,
        public string $firstName,
        public string $lastName,
    ) {
    }
}
