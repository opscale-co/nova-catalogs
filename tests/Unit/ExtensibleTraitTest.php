<?php

declare(strict_types=1);

use Opscale\NovaCatalogs\Models\Catalog;

it('returns the default when a key is missing', function (): void {
    $catalog = new Catalog(['data' => []]);

    expect($catalog->getData('missing', 'fallback'))->toBe('fallback');
});

it('reads, writes, checks and removes dynamic data keys', function (): void {
    $catalog = new Catalog(['data' => ['existing' => 'value']]);

    expect($catalog->hasData('existing'))->toBeTrue()
        ->and($catalog->getData('existing'))->toBe('value');

    $catalog->setData('color', 'red');

    expect($catalog->hasData('color'))->toBeTrue()
        ->and($catalog->getData('color'))->toBe('red');

    $catalog->removeData('color');

    expect($catalog->hasData('color'))->toBeFalse()
        ->and($catalog->getData('color', 'gone'))->toBe('gone');
});

it('exposes appended data keys via attribute access', function (): void {
    $catalog = new Catalog(['data' => ['priority' => 'high']]);
    $catalog->setAppends(['priority']);

    expect($catalog->getAttribute('priority'))->toBe('high');
});

it('writes appended data keys back into the data column', function (): void {
    $catalog = new Catalog(['data' => []]);
    $catalog->setAppends(['priority']);

    $catalog->setAttribute('priority', 'low');

    expect($catalog->getData('priority'))->toBe('low');
});
