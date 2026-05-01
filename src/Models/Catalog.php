<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Opscale\NovaCatalogs\Models\Concerns\Extensible;
use Opscale\NovaCatalogs\Models\Repositories\CatalogRepository;
use Opscale\Validations\Validatable;

class Catalog extends Model
{
    use CatalogRepository;
    use Extensible;
    use HasUlids;
    use Validatable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'key',
        'description',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * @return array<string, array<int, string>>
     */
    public function validationRules(): array
    {
        return [
            'description' => ['nullable', 'max:512'],
            'name' => ['required', 'max:256'],
            'key' => ['required', 'max:25', 'unique:catalogs,key'],
            'data' => ['nullable', 'json'],
        ];
    }

    public function items()
    {
        return $this->hasMany(CatalogItem::class);
    }

    public function catalogable()
    {
        return $this->morphTo();
    }
}
