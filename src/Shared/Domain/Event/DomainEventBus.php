<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

interface DomainEventBus
{
    public function dispatchStream(DomainEventStream $domainEventStream): void;
}
