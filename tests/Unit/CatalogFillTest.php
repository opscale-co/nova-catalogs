<?php

declare(strict_types=1);

use Opscale\NovaCatalogs\Models\Catalog;
use Opscale\NovaCatalogs\Models\CatalogItem;

it('mass-assigns the catalog fillable attributes', function (): void {
    $catalog = new Catalog([
        'name' => 'Colors',
        'key' => 'colors',
        'description' => 'Brand palette',
        'data' => ['scope' => 'brand'],
    ]);

    expect($catalog->name)->toBe('Colors')
        ->and($catalog->key)->toBe('colors')
        ->and($catalog->description)->toBe('Brand palette')
        ->and($catalog->data)->toBe(['scope' => 'brand']);
});

it('does not mass-assign attributes outside the catalog fillable list', function (): void {
    $catalog = new Catalog([
        'name' => 'Colors',
        'key' => 'colors',
        'catalogable_type' => 'spoofed',
        'catalogable_id' => 'spoofed',
    ]);

    expect($catalog->getAttribute('catalogable_type'))->toBeNull()
        ->and($catalog->getAttribute('catalogable_id'))->toBeNull();
});

it('mass-assigns the catalog item fillable attributes', function (): void {
    $item = new CatalogItem([
        'catalog_id' => '01HZ0PRRGR0000000000000000',
        'name' => 'Red',
        'key' => 'red',
        'description' => 'Primary',
        'data' => ['hex' => '#ff0000'],
    ]);

    expect($item->catalog_id)->toBe('01HZ0PRRGR0000000000000000')
        ->and($item->name)->toBe('Red')
        ->and($item->key)->toBe('red')
        ->and($item->description)->toBe('Primary')
        ->and($item->data)->toBe(['hex' => '#ff0000']);
});

it('keeps the data array intact through fill and re-read', function (): void {
    $catalog = new Catalog;
    $catalog->fill(['data' => ['nested' => ['a' => 1, 'b' => 2]]]);

    expect($catalog->data)->toBe(['nested' => ['a' => 1, 'b' => 2]]);
});

it('respects fill on an already constructed catalog item', function (): void {
    $item = new CatalogItem;
    $item->fill([
        'catalog_id' => '01HZ0PRRGR0000000000000000',
        'name' => 'Blue',
        'key' => 'blue',
    ]);

    expect($item->name)->toBe('Blue')
        ->and($item->key)->toBe('blue');
});
