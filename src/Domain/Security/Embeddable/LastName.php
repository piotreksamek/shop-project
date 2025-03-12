<?php

declare(strict_types=1);

namespace App\Domain\Security\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use InvalidArgumentException;

#[Embeddable]
class LastName
{
    public function __construct(
        #[Column(type: Types::STRING, length: 100)]
        private string $lastName,
    ) {
        self::validate($lastName);
    }

    public static function validate(string $lastName): void
    {
        if (strlen($lastName) > 100) {
            throw new InvalidArgumentException('Niepoprawny format kodu pocztowego');
        }
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}
