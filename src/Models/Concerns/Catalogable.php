<?php

namespace Opscale\NovaCatalogs\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Opscale\NovaCatalogs\Models\Catalog;

trait Catalogable
{
    public function catalogs(): MorphMany
    {
        return $this->morphMany(Catalog::class, 'catalogable');
    }
}
