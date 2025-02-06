<?php

declare(strict_types=1);

namespace App\Application\Security\DTO\Api;

use App\Application\Security\Validator\EmailExist;
use App\Application\Security\Validator\PasswordStrength;
use App\Application\Security\Validator\SameAsPassword;
use Symfony\Component\Validator\Constraints as Assert;

readonly class UserDTO
{
    public function __construct(
        #[EmailExist]
        #[Assert\Email]
        #[Assert\NotBlank]
        public string $email,
        #[Assert\NotBlank]
        #[PasswordStrength]
        public string $password,
        #[SameAsPassword]
        #[Assert\NotBlank]
        public string $confirmPassword,
    ) {
    }
}
