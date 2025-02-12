<?php

declare(strict_types=1);

namespace App\Domain\Security\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use InvalidArgumentException;

#[Embeddable]
class PostalCode
{
    public function __construct(
        #[Column(type: Types::STRING, length: 6, nullable: true)]
        public ?string $postalCode = null
    ) {
        if ($postalCode) {
            self::validate($postalCode);
        }
    }

    public static function validate(?string $postalCode): void
    {
        $pattern = '/^\d{2}-\d{3}$/';

        if (!preg_match($pattern, $postalCode)) {
            throw new InvalidArgumentException('Niepoprawny format kodu pocztowego');
        }
    }
}
