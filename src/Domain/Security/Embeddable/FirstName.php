<?php

declare(strict_types=1);

namespace App\Domain\Security\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use InvalidArgumentException;

#[Embeddable]
class FirstName
{
    public function __construct(
        #[Column(type: Types::STRING, length: 100)]
        private string $firstName,
    ) {
        self::validate($firstName);
    }

    public static function validate(string $firstName): void
    {
        if (strlen($firstName) > 100) {
            throw new InvalidArgumentException('Niepoprawny format kodu pocztowego');
        }
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }
}
