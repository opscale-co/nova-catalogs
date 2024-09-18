<?php

namespace Opscale\NovaCatalogs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Catalog extends Model
{
    public $timestamps = false;

    public static function fromSlug($slug)
    {
        return Cache::rememberForever('catalogs.' . $slug, function () use ($slug) {
            return static::with('items')->whereHas('items', function ($query) {
                $query->orderBy('name');
            })->where('slug', $slug)->first();
        });
    }

    public static function optionsFromSlug($slug)
    {
        $collection = static::fromSlug($slug);

        return $collection->items->pluck('name', 'key');
    }

    public static function optionsFromParent($slug, $parentKey)
    {
        $catalog = static::fromSlug($slug);
        $parent = CatalogItem::where('catalog_id', $catalog->id)
            ->where('key', $parentKey)
            ->first();

        $collection = CatalogItem::where('parent', $parent->id)
            ->orderBy('name')
            ->get();

        return $collection->pluck('name', 'key');
    }

    public static function item($slug, $itemKey)
    {
        $collection = static::withIdentifier($slug);
        $value = $collection->first(function ($value, $key) use ($itemKey) {
            return $key == $itemKey;
        });

        return $value ?? $itemKey;
    }

    protected static function rules()
    {
        return [
            'description' => ['nullable', 'max:512'],
            'name' => ['required', 'max:256'],
            'slug' => ['required', 'max:25'],
        ];
    }

    public function items()
    {
        return $this->hasMany(CatalogItem::class);
    }
}
