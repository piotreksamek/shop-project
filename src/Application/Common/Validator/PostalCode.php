<?php

declare(strict_types=1);

namespace App\Application\Common\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PostalCode extends Constraint
{
    public string $message = 'Podany Kod pocztowy jest niepoprawny';

    public function __construct(mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);
    }
}
