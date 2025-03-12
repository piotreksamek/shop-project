<?php

declare(strict_types=1);

namespace App\Domain\Product\Event;

use App\Shared\Domain\Event\DomainEvent;
use Symfony\Component\Uid\Uuid;

class ProductCreated implements DomainEvent
{
    public function __construct(public readonly Uuid $productId) {}
}
