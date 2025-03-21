<?php

declare(strict_types=1);

namespace App\Domain\Product\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Description
{
    public function __construct(
        #[Column(type: Types::TEXT)]
        private string $description
    ) {
        if (strlen($description) > 2000) {
            throw new \InvalidArgumentException('Description cannot be longer than 2000 characters');
        }
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
