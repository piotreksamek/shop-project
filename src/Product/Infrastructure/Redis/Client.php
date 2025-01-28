<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Redis;

use Redis;

class Client
{
    public function __construct(private readonly Redis $redis)
    {
    }

    public function get(string $key): mixed
    {
        return $this->redis->get($key);
    }
}