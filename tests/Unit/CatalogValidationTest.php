<?php

declare(strict_types=1);

use Illuminate\Validation\ValidationException;
use Opscale\NovaCatalogs\Models\Catalog;

it('passes validation with all valid attributes', function (): void {
    $catalog = new Catalog([
        'name' => 'Colors',
        'key' => 'colors',
        'description' => 'Brand palette',
        'data' => ['scope' => 'brand'],
    ]);

    expect(fn () => $catalog->validate())->not->toThrow(ValidationException::class);
});

it('allows description and data to be null', function (): void {
    $catalog = new Catalog([
        'name' => 'Colors',
        'key' => 'colors',
    ]);

    expect(fn () => $catalog->validate())->not->toThrow(ValidationException::class);
});

it('fails validation when the name is missing', function (): void {
    $catalog = new Catalog(['key' => 'colors']);

    expect(fn () => $catalog->validate())
        ->toThrow(ValidationException::class);
});

it('fails validation when the name exceeds 256 characters', function (): void {
    $catalog = new Catalog([
        'name' => str_repeat('a', 257),
        'key' => 'colors',
    ]);

    expect(fn () => $catalog->validate())
        ->toThrow(ValidationException::class);
});

it('fails validation when the key is missing', function (): void {
    $catalog = new Catalog(['name' => 'Colors']);

    expect(fn () => $catalog->validate())
        ->toThrow(ValidationException::class);
});

it('fails validation when the key exceeds 25 characters', function (): void {
    $catalog = new Catalog([
        'name' => 'Colors',
        'key' => str_repeat('k', 26),
    ]);

    expect(fn () => $catalog->validate())
        ->toThrow(ValidationException::class);
});

it('fails validation when the description exceeds 512 characters', function (): void {
    $catalog = new Catalog([
        'name' => 'Colors',
        'key' => 'colors',
        'description' => str_repeat('d', 513),
    ]);

    expect(fn () => $catalog->validate())
        ->toThrow(ValidationException::class);
});

it('exposes failing fields through the validation exception errors bag', function (): void {
    try {
        (new Catalog(['key' => 'colors']))->validate();
        $thrown = false;
        $errors = [];
    } catch (ValidationException $e) {
        $thrown = true;
        $errors = $e->errors();
    }

    expect($thrown)->toBeTrue()
        ->and($errors)->toHaveKey('name');
});

it('fails validation when the key is already used by another catalog', function (): void {
    Catalog::create(['name' => 'First', 'key' => 'shared']);

    expect(fn () => (new Catalog(['name' => 'Second', 'key' => 'shared']))->validate())
        ->toThrow(ValidationException::class);
});
