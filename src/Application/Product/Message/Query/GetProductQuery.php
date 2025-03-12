<?php

declare(strict_types=1);

namespace App\Application\Product\Message\Query;

use App\Shared\Messenger\QueryBus\Query;
use Symfony\Component\Uid\Uuid;

class GetProductQuery implements Query
{
    public function __construct(
        public Uuid $id,
    ) {}
}
