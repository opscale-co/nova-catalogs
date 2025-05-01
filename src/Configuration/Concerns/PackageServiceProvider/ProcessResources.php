<?php

namespace Opscale\NovaCatalogs\Configuration\Concerns\PackageServiceProvider;

use Laravel\Nova\Nova;

trait ProcessResources
{
    protected function bootPackageResources(): self
    {
        if (empty($this->package->resources)) {
            return $this;
        }

        Nova::resources($this->package->resources);

        return $this;
    }
}
