<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs\Tests;

use Illuminate\Support\Facades\Route;
use Laravel\Nova\NovaCoreServiceProvider;
use Laravel\Nova\NovaServiceProvider;
use Opscale\NovaCatalogs\PackageServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Override;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        Route::middlewareGroup('nova', []);
    }

    #[Override]
    protected function getPackageProviders($app): array
    {
        return array_merge(parent::getPackageProviders($app), [
            PackageServiceProvider::class,
            NovaCoreServiceProvider::class,
            NovaServiceProvider::class,
        ]);
    }

    #[Override]
    protected function defineEnvironment($app): void
    {
        parent::defineEnvironment($app);

        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    #[Override]
    protected function defineDatabaseMigrations(): void
    {
        parent::defineDatabaseMigrations();

        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
