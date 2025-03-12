<?php

declare(strict_types=1);

namespace App\Application\Security\Message;

use App\Shared\Messenger\CommandBus\Command;

readonly class VerifiedUserEmailCommand implements Command
{
    public function __construct(
        public string $token,
    ) {}
}
