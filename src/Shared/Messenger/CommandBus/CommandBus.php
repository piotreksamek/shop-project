<?php

declare(strict_types=1);

namespace App\Shared\Messenger\CommandBus;

interface CommandBus
{
    public function dispatch(Command $command): void;
}
