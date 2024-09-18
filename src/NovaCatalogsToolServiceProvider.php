<?php

namespace Opscale\NovaCatalogs;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Opscale\NovaCatalogs\Nova\Catalog;
use Opscale\NovaCatalogs\Nova\CatalogItem;

class NovaCatalogsToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->migrations();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Nova::resources([Catalog::class, CatalogItem::class]);
    }

    /**
     * Bootstrap database migrations.
     */
    protected function migrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
