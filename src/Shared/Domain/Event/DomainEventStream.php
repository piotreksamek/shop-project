<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

class DomainEventStream
{
    public function __construct(
        public array $uncommitedEvents
    ) {
    }
}
