<?php

declare(strict_types=1);

use Illuminate\Database\QueryException;
use Opscale\NovaCatalogs\Models\Catalog;
use Opscale\NovaCatalogs\Models\CatalogItem;

it('persists a catalog with items and reads them back via relationships', function (): void {
    $catalog = Catalog::query()->create([
        'name' => 'Colors',
        'key' => 'colors',
        'description' => 'Brand colors',
        'data' => ['scope' => 'brand'],
    ]);

    $catalog->items()->create([
        'name' => 'Red',
        'key' => 'red',
        'data' => ['hex' => '#ff0000'],
    ]);
    $catalog->items()->create([
        'name' => 'Blue',
        'key' => 'blue',
        'data' => ['hex' => '#0000ff'],
    ]);

    $stored = Catalog::with('items')->where('key', 'colors')->firstOrFail();

    expect($stored->id)->not->toBeEmpty()
        ->and($stored->data)->toBe(['scope' => 'brand'])
        ->and($stored->items)->toHaveCount(2)
        ->and($stored->items->firstWhere('key', 'red')?->data)->toBe(['hex' => '#ff0000'])
        ->and($stored->items->first()?->catalog->key)->toBe('colors');
});

it('enforces the unique key constraint on catalogs', function (): void {
    Catalog::query()->create([
        'name' => 'First',
        'key' => 'duplicate',
    ]);

    expect(fn () => Catalog::query()->create([
        'name' => 'Second',
        'key' => 'duplicate',
    ]))->toThrow(QueryException::class);
});

it('enforces the unique catalog_id + key constraint on catalog items', function (): void {
    $catalog = Catalog::query()->create([
        'name' => 'Sizes',
        'key' => 'sizes',
    ]);

    $catalog->items()->create([
        'name' => 'Small',
        'key' => 'small',
    ]);

    expect(fn () => $catalog->items()->create([
        'name' => 'Small clone',
        'key' => 'small',
    ]))->toThrow(QueryException::class);
});

it('allows the same item key in different catalogs', function (): void {
    $catalog = Catalog::query()->create(['name' => 'A', 'key' => 'a']);
    $b = Catalog::query()->create(['name' => 'B', 'key' => 'b']);

    $catalog->items()->create(['name' => 'Default', 'key' => 'default']);
    $b->items()->create(['name' => 'Default', 'key' => 'default']);

    expect(CatalogItem::query()->where('key', 'default')->count())->toBe(2);
});
