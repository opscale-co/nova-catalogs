<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs\Models\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * @phpstan-require-extends Model
 */
trait Extensible
{
    #[\Override]
    public function hasGetMutator($key): bool
    {
        if (in_array($key, $this->getAppends(), true)) {
            return true;
        }

        return parent::hasGetMutator($key);
    }

    #[\Override]
    public function hasSetMutator($key): bool
    {
        if (in_array($key, $this->getAppends(), true)) {
            return true;
        }

        return parent::hasSetMutator($key);
    }

    /**
     * Get a dynamic data value by key (with casts applied).
     */
    final public function getData(string $key, mixed $default = null): mixed
    {
        /** @var array<string, mixed> $data */
        $data = $this->getAttribute('data') ?? [];

        return $data[$key] ?? $default;
    }

    /**
     * Set a dynamic data value by key.
     */
    final public function setData(string $key, mixed $value): static
    {
        $data = $this->getRawData();
        $data[$key] = $value;
        $this->attributes['data'] = json_encode($data);

        return $this;
    }

    /**
     * Check if a dynamic data key exists.
     */
    final public function hasData(string $key): bool
    {
        /** @var array<string, mixed> $data */
        $data = $this->getAttribute('data') ?? [];

        return array_key_exists($key, $data);
    }

    /**
     * Remove a dynamic data key.
     */
    final public function removeData(string $key): static
    {
        $data = $this->getRawData();
        unset($data[$key]);
        $this->attributes['data'] = json_encode($data);

        return $this;
    }

    #[\Override]
    protected function mutateAttribute($key, $value): mixed
    {
        if (in_array($key, $this->getAppends(), true)) {
            return $this->getData($key);
        }

        return parent::mutateAttribute($key, $value);
    }

    #[\Override]
    protected function setMutatedAttributeValue($key, $value): mixed
    {
        if (in_array($key, $this->getAppends(), true)) {
            return $this->setData($key, $value);
        }

        return parent::setMutatedAttributeValue($key, $value);
    }

    /**
     * Get raw data without triggering casts.
     *
     * @return array<string, mixed>
     */
    final protected function getRawData(): array
    {
        $raw = $this->attributes['data'] ?? null;

        if ($raw === null) {
            return [];
        }

        if (is_array($raw)) {
            /** @var array<string, mixed> $raw */
            return $raw;
        }

        if (! is_string($raw)) {
            return [];
        }

        /** @var array<string, mixed>|null $decoded */
        $decoded = json_decode($raw, true);

        return $decoded ?? [];
    }
}
