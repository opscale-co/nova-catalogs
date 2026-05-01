<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Opscale\NovaCatalogs\Models\Concerns\Catalogable;
use Opscale\NovaCatalogs\Models\Concerns\Extensible;
use Opscale\Validations\Validatable;

class CatalogItem extends Model
{
    use Catalogable;
    use Extensible;
    use HasUlids;
    use Validatable;

    public $timestamps = false;

    public $casts = [
        'data' => 'array',
    ];

    protected $fillable = [
        'catalog_id',
        'name',
        'key',
        'description',
        'data',
    ];

    /**
     * @return array<string, array<int, string>>
     */
    public function validationRules(): array
    {
        return [
            'description' => ['nullable', 'max:512'],
            'name' => ['required', 'max:256'],
            'key' => ['required', 'max:25', 'unique:catalog_items,key'],
            'data' => ['nullable', 'json'],
        ];
    }

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function catalogs(): MorphMany
    {
        return $this->morphMany(Catalog::class, 'catalogable');
    }
}
