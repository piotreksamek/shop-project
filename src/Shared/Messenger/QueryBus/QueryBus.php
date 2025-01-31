<?php

declare(strict_types=1);

namespace App\Shared\Messenger\QueryBus;

use App\Shared\Messenger\QueryBus\Definition\QueryCacheDefinition;

interface QueryBus
{
    public function handle(Query $query, ?QueryCacheDefinition $queryCacheDefinition = null): mixed;

    public function cacheExist(Query $query): bool;
}
