<?php

declare(strict_types=1);

namespace App\Domain\Product\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use InvalidArgumentException;

#[Embeddable]
class Name
{
    public function __construct(
        #[Column(type: Types::STRING, length: 255)]
        private string $name
    ) {
        if (strlen($name) > 255) {
            throw new InvalidArgumentException('Name cannot be longer than 255 characters');
        }
    }

    public function getName(): string
    {
        return $this->name;
    }
}
