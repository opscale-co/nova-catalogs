<?php

namespace Opscale\NovaCatalogs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Catalog extends Model
{
    public $timestamps = false;

    public static function fromSlug(string $slug): Catalog
    {
        $cacheKey = 'opscale.catalogs.' . $slug;

        return Cache::rememberForever($cacheKey, function () use ($slug) {
            return static::with('items')->whereHas('items', function ($query) {
                $query->orderBy('name');
            })->where('slug', $slug)->first();
        });
    }

    public static function options(string $slug): array
    {
        $catalog = static::fromSlug($slug);

        return $catalog->items->pluck('name', 'key')->toArray();
    }

    public static function optionsFromParent(string $slug, string $parentKey): array
    {
        $catalog = static::fromSlug($slug);
        $parent = CatalogItem::where('catalog_id', $catalog->id)
            ->where('key', $parentKey)
            ->first();

        $collection = CatalogItem::where('parent', $parent->id)
            ->orderBy('name')
            ->get();

        return $collection->pluck('name', 'key')->toArray();
    }

    public static function optionsFromPredicate(string $slug, callable $callback): array
    {
        $catalog = static::fromSlug($slug);

        $collection = $catalog->items->filter(function ($item) use ($callback) {
            return $callback($item);
        });

        return $collection->pluck('name', 'key')->toArray();
    }

    public static function itemFromKey(string $slug, string $itemKey): CatalogItem
    {
        $options = static::options($slug);
        $item = $options->first(function ($value, $key) use ($itemKey) {
            return $key == $itemKey;
        });

        return $item;
    }

    protected static function rules(string $property)
    {
        $rules = [
            'description' => ['nullable', 'max:512'],
            'name' => ['required', 'max:256'],
            'slug' => ['required', 'max:25'],
        ];

        return isset($rules[$property]) ? $rules[$property] : null;
    }

    public function items()
    {
        return $this->hasMany(CatalogItem::class);
    }
}
