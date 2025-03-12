<?php

declare(strict_types=1);

namespace App\Application\User\DTO\Api;

use App\Domain\Security\Entity\User;

readonly class UserDTO
{
    public function __construct(
        public string $email,
        public BaseInformationDTO $baseInformation,
    ) {}

    public static function from(User $user): self
    {
        return new self(
            email: $user->getEmail(),
            baseInformation: BaseInformationDTO::from($user->getBaseInformation()),
        );
    }
}
