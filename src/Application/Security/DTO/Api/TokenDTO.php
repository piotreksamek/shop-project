<?php

declare(strict_types=1);

namespace App\Application\Security\DTO\Api;

use Symfony\Component\Validator\Constraints as Assert;

readonly class TokenDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $token
    ) {}
}
