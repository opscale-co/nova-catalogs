<?php

namespace Opscale\NovaCatalogs\Configuration;

use Opscale\NovaCatalogs\Configuration\Concerns\PackageServiceProvider\ProcessResources;
use Spatie\LaravelPackageTools\PackageServiceProvider;

abstract class NovaPackageServiceProvider extends PackageServiceProvider
{
    use ProcessResources;

    public function packageBooted()
    {
        $this->bootPackageResources();
    }
}
