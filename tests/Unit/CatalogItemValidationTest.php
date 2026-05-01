<?php

declare(strict_types=1);

use Illuminate\Validation\ValidationException;
use Opscale\NovaCatalogs\Models\Catalog;
use Opscale\NovaCatalogs\Models\CatalogItem;

it('passes validation with all valid attributes', function (): void {
    $item = new CatalogItem([
        'catalog_id' => '01HZ0PRRGR0000000000000000',
        'name' => 'Red',
        'key' => 'red',
        'description' => 'Primary red',
        'data' => ['hex' => '#ff0000'],
    ]);

    expect(fn () => $item->validate())->not->toThrow(ValidationException::class);
});

it('fails validation when the name is missing', function (): void {
    $item = new CatalogItem([
        'catalog_id' => '01HZ0PRRGR0000000000000000',
        'key' => 'red',
    ]);

    expect(fn () => $item->validate())
        ->toThrow(ValidationException::class);
});

it('fails validation when the name exceeds 256 characters', function (): void {
    $item = new CatalogItem([
        'catalog_id' => '01HZ0PRRGR0000000000000000',
        'name' => str_repeat('a', 257),
        'key' => 'red',
    ]);

    expect(fn () => $item->validate())
        ->toThrow(ValidationException::class);
});

it('fails validation when the key is missing', function (): void {
    $item = new CatalogItem([
        'catalog_id' => '01HZ0PRRGR0000000000000000',
        'name' => 'Red',
    ]);

    expect(fn () => $item->validate())
        ->toThrow(ValidationException::class);
});

it('fails validation when the key exceeds 25 characters', function (): void {
    $item = new CatalogItem([
        'catalog_id' => '01HZ0PRRGR0000000000000000',
        'name' => 'Red',
        'key' => str_repeat('k', 26),
    ]);

    expect(fn () => $item->validate())
        ->toThrow(ValidationException::class);
});

it('fails validation when the description exceeds 512 characters', function (): void {
    $item = new CatalogItem([
        'catalog_id' => '01HZ0PRRGR0000000000000000',
        'name' => 'Red',
        'key' => 'red',
        'description' => str_repeat('d', 513),
    ]);

    expect(fn () => $item->validate())
        ->toThrow(ValidationException::class);
});

it('reports both missing name and missing key in a single failure', function (): void {
    try {
        (new CatalogItem(['catalog_id' => '01HZ0PRRGR0000000000000000']))->validate();
        $errors = [];
    } catch (ValidationException $e) {
        $errors = $e->errors();
    }

    expect($errors)
        ->toHaveKey('name')
        ->toHaveKey('key');
});

it('fails validation when the key is already used by another item', function (): void {
    $catalog = Catalog::create(['name' => 'Sizes', 'key' => 'sizes']);
    $catalog->items()->create(['name' => 'Small', 'key' => 'small']);

    $duplicate = new CatalogItem([
        'catalog_id' => $catalog->id,
        'name' => 'Small clone',
        'key' => 'small',
    ]);

    expect(fn () => $duplicate->validate())
        ->toThrow(ValidationException::class);
});
