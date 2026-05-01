<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Cache;
use Opscale\NovaCatalogs\Models\Catalog;

$seed = static function (string $key, array $items): Catalog {
    $catalog = Catalog::create([
        'name' => ucfirst($key),
        'key' => $key,
    ]);

    foreach ($items as $itemKey => $name) {
        $catalog->items()->create([
            'name' => $name,
            'key' => $itemKey,
            'data' => ['enabled' => true],
        ]);
    }

    return $catalog->refresh();
};

beforeEach(function (): void {
    Cache::flush();
});

it('returns the catalog when fromKey matches an existing key', function () use ($seed): void {
    $seed('sizes', ['s' => 'Small', 'm' => 'Medium']);

    $catalog = Catalog::fromKey('sizes');

    expect($catalog)->not->toBeNull()
        ->and($catalog->key)->toBe('sizes')
        ->and($catalog->items)->toHaveCount(2);
});

it('returns null when no catalog matches the given key', function (): void {
    expect(Catalog::fromKey('does-not-exist'))->toBeNull();
});

it('skips catalogs that have no items', function (): void {
    Catalog::create(['name' => 'Empty', 'key' => 'empty']);

    expect(Catalog::fromKey('empty'))->toBeNull();
});

it('returns the cached catalog on subsequent calls', function () use ($seed): void {
    $catalog = $seed('colors', ['red' => 'Red']);

    Catalog::fromKey('colors');
    $catalog->delete();

    expect(Catalog::fromKey('colors'))
        ->not->toBeNull()
        ->key->toBe('colors');
});

it('returns a key-indexed associative array from options', function () use ($seed): void {
    $seed('priorities', [
        'low' => 'Low',
        'high' => 'High',
    ]);

    expect(Catalog::options('priorities'))
        ->toEqualCanonicalizing(['low' => 'Low', 'high' => 'High']);
});

it('returns an empty array from options when the catalog is missing', function (): void {
    expect(Catalog::options('missing'))->toBe([]);
});

it('applies the predicate when calling filteredOptions', function () use ($seed): void {
    $seed('regions', [
        'na' => 'North America',
        'eu' => 'Europe',
        'as' => 'Asia',
    ]);

    $result = Catalog::filteredOptions(
        'regions',
        fn ($item) => str_starts_with($item->name, 'N'),
    );

    expect($result)->toBe(['na' => 'North America']);
});
