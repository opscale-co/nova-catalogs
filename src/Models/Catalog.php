<?php

namespace Opscale\NovaCatalogs\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Opscale\NovaCatalogs\Models\Concerns\Extensible;
use Opscale\NovaCatalogs\Models\Repositories\CatalogRepository;

class Catalog extends Model
{
    use CatalogRepository;
    use Extensible;
    use HasUlids;

    public $timestamps = false;

    /**
     * @var array<string, array<int, string>>
     */
    public array $validationRules = [
        'description' => ['nullable', 'max:512'],
        'name' => ['required', 'max:256'],
        'key' => ['required', 'max:25'],
        'data' => ['nullable', 'json'],
    ];

    protected $fillable = [
        'name',
        'key',
        'description',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
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
