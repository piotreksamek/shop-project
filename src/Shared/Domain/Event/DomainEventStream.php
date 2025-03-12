<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

class DomainEventStream
{
    /** @param array<string, DomainEvent> $uncommitedEvents*/
    public function __construct(
        public array $uncommitedEvents
    ) {}
}
