<?php

declare(strict_types=1);

namespace App\Application\Product\Message\Query;

use App\Shared\Messenger\QueryBus\Query;

class GetProductsQuery implements Query
{
    public function __construct(public ?string $query = null)
    {
    }
}
