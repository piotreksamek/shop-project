<?php

declare(strict_types=1);

namespace App\Shared\Messenger\QueryBus;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class QueryBus
{
    use HandleTrait;

    public function __construct(private readonly MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function dispatch(Query $query): mixed
    {
        return $this->handle($query);
    }
}
