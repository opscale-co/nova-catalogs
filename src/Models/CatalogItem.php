<?php

namespace Opscale\NovaCatalogs\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class CatalogItem extends Model
{
    use HasUlids;

    public $timestamps = false;

    public $casts = [
        'metadata' => 'object',
    ];

    /**
     * @var array<string, array<int, string>>
     */
    public array $validationRules = [
        'name' => ['required', 'max:256'],
        'key' => ['required', 'max:25'],
        'metadata' => ['nullable', 'json'],
    ];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function catalogs(): MorphMany
    {
        return $this->morphMany(Catalog::class, 'catalogable');
    }
}
