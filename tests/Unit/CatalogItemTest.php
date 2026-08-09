<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Opscale\NovaCatalogs\Models\Catalog;
use Opscale\NovaCatalogs\Models\CatalogItem;
use Opscale\NovaCatalogs\Models\Concerns\Catalogable;
use Opscale\NovaCatalogs\Models\Concerns\Extensible;
use Opscale\Validations\Validatable;

it('does not use timestamps', function (): void {
    expect((new CatalogItem)->timestamps)->toBeFalse();
});

it('casts the data column to an array', function (): void {
    expect((new CatalogItem)->getCasts())
        ->toHaveKey('data', 'array');
});

it('declares validation rules for the editable attributes', function (): void {
    expect((new CatalogItem)->validationRules())
        ->toHaveKeys(['name', 'key', 'description', 'data']);
});

it('marks the catalog item key as unique through validation rules', function (): void {
    expect((new CatalogItem)->validationRules()['key'])
        ->toContain('unique:catalog_items,key');
});

it('exposes the expected fillable attributes', function (): void {
    expect((new CatalogItem)->getFillable())
        ->toBe(['catalog_id', 'name', 'key', 'description', 'data']);
});

it('uses ULIDs, catalogable, extensible and validatable traits', function (): void {
    $traits = class_uses_recursive(CatalogItem::class);

    expect($traits)
        ->toContain(HasUlids::class)
        ->toContain(Catalogable::class)
        ->toContain(Extensible::class)
        ->toContain(Validatable::class);
});

it('defines a belongsTo relation to a catalog', function (): void {
    $belongsTo = (new CatalogItem)->catalog();

    expect($belongsTo)->toBeInstanceOf(BelongsTo::class)
        ->and($belongsTo->getRelated())->toBeInstanceOf(Catalog::class);
});

it('defines a polymorphic catalogs relation through the catalogable trait', function (): void {
    $morphMany = (new CatalogItem)->catalogs();

    expect($morphMany)->toBeInstanceOf(MorphMany::class)
        ->and($morphMany->getRelated())->toBeInstanceOf(Catalog::class);
});
