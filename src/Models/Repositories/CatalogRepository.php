<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs\Models\Repositories;

use Illuminate\Support\Facades\Cache;
use Opscale\NovaCatalogs\Models\Catalog;

/**
 * @phpstan-require-extends Catalog
 */
trait CatalogRepository
{
    final public static function fromKey(string $key): ?Catalog
    {
        $cacheKey = 'opscale.catalogs.'.$key;

        return Cache::rememberForever($cacheKey, static function () use ($key): ?Catalog {
            return static::with('items')
                ->whereHas('items', static function ($query): void {
                    $query->orderBy('name');
                })
                ->where('key', $key)
                ->first();
        });
    }

    /**
     * @return array<string, string>
     */
    final public static function options(string $key): array
    {
        $catalog = static::fromKey($key);

        if ($catalog === null) {
            return [];
        }

        /** @var array<string, string> $options */
        $options = $catalog->items->pluck('name', 'key')->toArray();

        return $options;
    }

    /**
     * @return array<string, string>
     */
    final public static function filteredOptions(string $key, callable $filter): array
    {
        $catalog = static::fromKey($key);

        if ($catalog === null) {
            return [];
        }

        /** @var array<string, string> $options */
        $options = $catalog->items
            ->filter(static fn ($item): bool => (bool) $filter($item))
            ->pluck('name', 'key')
            ->toArray();

        return $options;
    }
}
