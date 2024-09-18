<?php

namespace Opscale\NovaCatalogs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CatalogItem extends Model
{
    public $timestamps = false;

    public $casts = [
        'metadata' => 'object',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->key = $model->key ?? Str::slug($model->name);
        });
    }

    protected static function rules()
    {
        return [
            'name' => ['required', 'max:50'],
            'key' => ['required', 'max:25'],
        ];
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
