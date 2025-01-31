<?php

declare(strict_types=1);

namespace App\Shared\Messenger\QueryBus\Definition;

class CacheTagsDefinition
{
    public const PRODUCT_LIST_CACHE_TAG = 'product';
    public const PRODUCT_CACHE_TAG = 'product_%s';

    public static function getProductListCacheTag(): string
    {
        return self::PRODUCT_LIST_CACHE_TAG;
    }

    public static function getProductCacheTag(string $productId): string
    {
        return sprintf(self::PRODUCT_CACHE_TAG, $productId);
    }
}
