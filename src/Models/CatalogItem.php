<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Opscale\NovaCatalogs\Models\Concerns\Catalogable;
use Opscale\NovaCatalogs\Models\Concerns\Extensible;
use Opscale\Validations\Validatable;

/**
 * @property string $id
 * @property string $catalog_id
 * @property string $name
 * @property string $key
 * @property string|null $description
 * @property array<string, mixed>|null $data
 * @property-read Catalog $catalog
 */
class CatalogItem extends Model
{
    use Catalogable;
    use Extensible;
    use HasUlids;
    use Validatable;

    public $timestamps = false;

    /** @var array<string, string> */
    public $casts = [
        'data' => 'array',
    ];

    /** @var list<string> */
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
    final public function validationRules(): array
    {
        return [
            'description' => ['nullable', 'max:512'],
            'name' => ['required', 'max:256'],
            'key' => ['required', 'max:25', 'unique:catalog_items,key'],
            'data' => ['nullable', 'json'],
        ];
    }

    /**
     * @return BelongsTo<Catalog, $this>
     */
    final public function catalog(): BelongsTo
    {
        return $this->belongsTo(Catalog::class);
    }
}
