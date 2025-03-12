<?php

declare(strict_types=1);

namespace App\Shared\Messenger\QueryBus\Definition;

final class QueryCacheDefinition
{
    public const EXPIRATION_TIME_HOUR = 3600;
    public const EXPIRATION_TIME_MINUTE = 60;

    private int $expirationTime = self::EXPIRATION_TIME_MINUTE;

    /** @var string[]  */
    private array $tags = [];

    public static function create(): self
    {
        return new self();
    }

    /** @param string[] $tags */
    public function withTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /** @return string[] */
    public function getTags(): array
    {
        return $this->tags;
    }

    public function withExpirationTime(int $expirationTime): self
    {
        $this->expirationTime = $expirationTime;

        return $this;
    }

    public function getExpirationTime(): int
    {
        return $this->expirationTime;
    }
}
