<?php

namespace Opscale\NovaCatalogs;

use Opscale\NovaCatalogs\Configuration\NovaPackage;
use Opscale\NovaCatalogs\Configuration\NovaPackageServiceProvider;
use Opscale\NovaCatalogs\Nova\Catalog;
use Opscale\NovaCatalogs\Nova\CatalogItem;
use Spatie\LaravelPackageTools\Package;

class ToolServiceProvider extends NovaPackageServiceProvider
{
    public function newPackage(): Package
    {
        return new NovaPackage;
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('nova-catalogs')
            ->discoversMigrations()
            ->runsMigrations()
            ->hasResources([Catalog::class, CatalogItem::class]);
    }
}
