<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

class DomainEventDispatcher
{
    /** @var DomainEvent[] */
    private array $events = [];

    public function record(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    /** @return DomainEvent[] */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
