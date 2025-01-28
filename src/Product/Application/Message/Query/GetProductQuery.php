<?php

declare(strict_types=1);

namespace App\Product\Application\Message\Query;

use App\Shared\Messenger\QueryBus\Query;

class GetProductQuery implements Query
{
    public function __construct(
        public string $id,
    ) {
    }
}
