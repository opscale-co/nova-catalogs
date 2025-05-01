<?php

namespace Opscale\NovaCatalogs\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogItem extends Model
{
    public $timestamps = false;

    public $casts = [
        'metadata' => 'object',
    ];

    protected static function rules(string $property)
    {
        $rules = [
            'name' => ['required', 'max:50'],
            'key' => ['required', 'max:25'],
        ];

        return isset($rules[$property]) ? $rules[$property] : null;
    }

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function parent()
    {
        return $this->belongsTo(CatalogItem::class);
    }
}
