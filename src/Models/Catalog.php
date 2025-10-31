<?php

namespace Opscale\NovaCatalogs\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Opscale\NovaCatalogs\Concerns\Catalogable;
use Opscale\NovaCatalogs\Models\Repositories\CatalogRepository;

class Catalog extends Model
{
    use CatalogRepository;
    use Catalogable;
    use HasUlids;

    public $timestamps = false;

    /**
     * @var array<string, array<int, string>>
     */
    public array $validationRules = [
        'description' => ['nullable', 'max:512'],
        'name' => ['required', 'max:256'],
        'key' => ['required', 'max:25'],
        'metadata' => ['nullable', 'json'],
    ];

    protected $fillable = [
        'name',
        'key',
        'description',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(CatalogItem::class);
    }

    public function catalogable()
    {
        return $this->morphTo();
    }
}
