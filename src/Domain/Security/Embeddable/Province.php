<?php

declare(strict_types=1);

namespace App\Domain\Security\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use InvalidArgumentException;

#[Embeddable]
class Province
{
    public function __construct(
        #[Column(type: Types::STRING, length: 100, nullable: true)]
        public ?string $province = null
    ) {
        if ($province) {
            self::validate($province);
        }
    }

    public static function validate(?string $province): void
    {
        if (strlen($province) > 100) {
            throw new InvalidArgumentException('Data is too long.');
        }
    }
}