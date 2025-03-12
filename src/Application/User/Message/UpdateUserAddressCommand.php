<?php

declare(strict_types=1);

namespace App\Application\User\Message;

use App\Shared\Messenger\CommandBus\Command;
use Symfony\Component\Uid\Uuid;

class UpdateUserAddressCommand implements Command
{
    public function __construct(
        public Uuid $userId,
        public ?string $street = null,
        public ?string $number = null,
        public ?string $apartmentNumber = null,
        public ?string $city = null,
        public ?string $postalCode = null,
        public ?string $province = null,
    ) {}
}
