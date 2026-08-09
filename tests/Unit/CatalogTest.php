<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Opscale\NovaCatalogs\Models\Catalog;
use Opscale\NovaCatalogs\Models\CatalogItem;
use Opscale\NovaCatalogs\Models\Concerns\Extensible;
use Opscale\NovaCatalogs\Models\Repositories\CatalogRepository;
use Opscale\Validations\Validatable;

it('does not use timestamps', function (): void {
    expect((new Catalog)->timestamps)->toBeFalse();
});

it('exposes the expected fillable attributes', function (): void {
    expect((new Catalog)->getFillable())
        ->toBe(['name', 'key', 'description', 'data']);
});

it('casts the data column to an array', function (): void {
    expect((new Catalog)->getCasts())
        ->toHaveKey('data', 'array');
});

it('declares validation rules for every fillable attribute', function (): void {
    $rules = (new Catalog)->validationRules();

    expect($rules)
        ->toHaveKeys(['name', 'key', 'description', 'data'])
        ->and($rules['name'])->toContain('required')
        ->and($rules['key'])
        ->toContain('required')
        ->toContain('unique:catalogs,key');
});

it('uses ULIDs, the repository, extensible and validatable traits', function (): void {
    $traits = class_uses_recursive(Catalog::class);

    expect($traits)
        ->toContain(HasUlids::class)
        ->toContain(CatalogRepository::class)
        ->toContain(Extensible::class)
        ->toContain(Validatable::class);
});

it('defines a hasMany relation to catalog items', function (): void {
    $hasMany = (new Catalog)->items();

    expect($hasMany)->toBeInstanceOf(HasMany::class)
        ->and($hasMany->getRelated())->toBeInstanceOf(CatalogItem::class);
});

it('defines a polymorphic catalogable relation', function (): void {
    $morphTo = (new Catalog)->catalogable();

    expect($morphTo)->toBeInstanceOf(MorphTo::class)
        ->and($morphTo->getMorphType())->toBe('catalogable_type');
});
