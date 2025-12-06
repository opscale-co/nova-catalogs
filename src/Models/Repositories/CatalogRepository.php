<?php

namespace Opscale\NovaCatalogs\Models\Repositories;

use Illuminate\Support\Facades\Cache;
use Opscale\NovaCatalogs\Models\Catalog;

trait CatalogRepository
{
    public static function fromKey(string $key): ?Catalog
    {
        $cacheKey = 'opscale.catalogs.' . $key;

        return Cache::rememberForever($cacheKey, function () use ($key) {
            return static::with('items')->whereHas('items', function ($query) {
                $query->orderBy('name');
            })->where('key', $key)->first();
        });
    }

    public static function options(string $key): array
    {
        $catalog = static::fromKey($key);

        return $catalog == null ? [] :
            $catalog->items->pluck('name', 'key')->toArray();
    }

    public static function filteredOptions(string $key, callable $filter): array
    {
        $catalog = static::fromKey($key);

        $collection = $catalog == null ? [] :
            $catalog->items->filter(function ($item) use ($filter) {
                return $filter($item);
            });

        return $collection->pluck('name', 'key')->toArray();
    }
}
