<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyDomainEventBus implements DomainEventBus
{
    public function __construct(private MessageBusInterface $eventBus) {}

    public function dispatchStream(DomainEventStream $domainEventStream): void
    {
        foreach ($domainEventStream->uncommitedEvents as $uncommitedEvent) {
            $this->eventBus->dispatch($uncommitedEvent);
        }
    }
}
