<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

trait DomainEventTrait
{
    private array $uncommittedEvents = [];

    public function apply(DomainEvent $event): void
    {
        $this->uncommittedEvents[$event::class] = $event;
    }

    public function getUncommittedEvents(): DomainEventStream
    {
        $stream = new DomainEventStream($this->uncommittedEvents);
        $this->uncommittedEvents = [];

        return $stream;
    }
}
