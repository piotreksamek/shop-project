<?php

declare(strict_types=1);

namespace App\Domain\Security\Event;

use App\Shared\Domain\Event\DomainEvent;
use Symfony\Component\Uid\Uuid;

class UserRegistered implements DomainEvent
{
    public function __construct(
        public Uuid $userId,
        public string $email,
        public ?string $emailVerificationToken = null,
    ) {}
}
