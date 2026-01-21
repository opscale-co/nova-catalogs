<?php

namespace Opscale\NovaCatalogs\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Opscale\NovaCatalogs\Models\Concerns\Catalogable;
use Opscale\NovaCatalogs\Models\Concerns\Extensible;

class CatalogItem extends Model
{
    use Catalogable;
    use Extensible;
    use HasUlids;

    public $timestamps = false;

    public $casts = [
        'data' => 'array',
    ];

    /**
     * @var array<string, array<int, string>>
     */
    public array $validationRules = [
        'description' => ['nullable', 'max:512'],
        'name' => ['required', 'max:256'],
        'key' => ['required', 'max:25'],
        'data' => ['nullable', 'json'],
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
