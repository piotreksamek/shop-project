<?php

declare(strict_types=1);

namespace App\Product\Domain\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use InvalidArgumentException;

#[Embeddable]
class Description
{
    public function __construct(
        #[Column(type: Types::TEXT)]
        private string $description
    ) {
        if (strlen($description) > 2000) {
            throw new InvalidArgumentException('Description cannot be longer than 2000 characters');
        }
    }
}