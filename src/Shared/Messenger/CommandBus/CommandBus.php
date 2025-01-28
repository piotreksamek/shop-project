<?php

declare(strict_types=1);

namespace App\Shared\Messenger\CommandBus;

use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus
{
    public function __construct(private readonly MessageBusInterface $commandBus)
    {
    }

    public function dispatch(MessageCommandInterface $command): void
    {
        $this->commandBus->dispatch($command);
    }
}