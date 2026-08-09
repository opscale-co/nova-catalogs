<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Opscale\NovaCatalogs\Models\Concerns\Extensible;
use Opscale\NovaCatalogs\Models\Repositories\CatalogRepository;
use Opscale\Validations\Validatable;

/**
 * @property string $id
 * @property string $name
 * @property string $key
 * @property string|null $description
 * @property array<string, mixed>|null $data
 * @property string|null $catalogable_type
 * @property string|null $catalogable_id
 * @property-read Collection<int, CatalogItem> $items
 * @property-read Model|null $catalogable
 */
class Catalog extends Model
{
    use CatalogRepository;
    use Extensible;
    use HasUlids;
    use Validatable;

    public $timestamps = false;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'key',
        'description',
        'data',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * @return array<string, array<int, string>>
     */
    final public function validationRules(): array
    {
        return [
            'description' => ['nullable', 'max:512'],
            'name' => ['required', 'max:256'],
            'key' => ['required', 'max:25', 'unique:catalogs,key'],
            'data' => ['nullable', 'json'],
        ];
    }

    /**
     * @return HasMany<CatalogItem, $this>
     */
    final public function items(): HasMany
    {
        return $this->hasMany(CatalogItem::class);
    }

    /**
     * @return MorphTo<Model, $this>
     */
    final public function catalogable(): MorphTo
    {
        return $this->morphTo();
    }
}
