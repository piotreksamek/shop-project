<?php

declare(strict_types=1);

namespace App\Domain\Product\Embeddable;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use InvalidArgumentException;

#[Embeddable]
class ShortDescription
{
    public function __construct(
        #[Column(type: Types::TEXT)]
        private string $shortDescription
    ) {
        if (strlen($shortDescription) > 200) {
            throw new InvalidArgumentException('Short description cannot be longer than 200 characters');
        }
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }
}
