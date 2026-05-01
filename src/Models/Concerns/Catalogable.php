<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Opscale\NovaCatalogs\Models\Catalog;

/**
 * @phpstan-require-extends Model
 */
trait Catalogable
{
    /**
     * @return MorphMany<Catalog, $this>
     */
    final public function catalogs(): MorphMany
    {
        return $this->morphMany(Catalog::class, 'catalogable');
    }
}
