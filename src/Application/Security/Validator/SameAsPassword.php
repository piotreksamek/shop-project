<?php

declare(strict_types=1);

namespace App\Application\Security\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class SameAsPassword extends Constraint
{
    public string $message = 'Hasła nie są takie same';

    public function __construct(?string $message = null, ?array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->message = $message ?? $this->message;
    }
}
