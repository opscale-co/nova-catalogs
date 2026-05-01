<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs;

use Opscale\NovaCatalogs\Nova\Catalog;
use Opscale\NovaCatalogs\Nova\CatalogItem;
use Opscale\NovaPackageTools\NovaPackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;

class PackageServiceProvider extends NovaPackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('nova-catalogs')
            ->discoversMigrations()
            ->runsMigrations()
            ->hasResources([
                Catalog::class,
                CatalogItem::class,
            ])
            ->hasTranslations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->askToStarRepoOnGitHub('opscale-co/nova-catalogs');
            });
    }
}
