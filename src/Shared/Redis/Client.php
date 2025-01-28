<?php

declare(strict_types=1);

namespace App\Shared\Redis;

use \Predis\Client as RedisClient;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class Client
{
    private RedisClient $redis;

    public function __construct(
        #[Autowire('%redis_dsn%')]
        private readonly string $host,
        #[Autowire('%redis_password%')]
        private readonly string $password,
    ) {
        $redis = new RedisClient($this->host);

        $redis->auth($this->password);

        $this->redis = $redis;
    }

    public function get(string $key): string
    {
        return $this->redis->get($key);
    }

    public function set(string $key, string $value): void
    {
        $this->redis->set($key, $value);
    }
}
