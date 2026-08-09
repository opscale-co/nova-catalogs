<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\Features;
use Laravel\Nova\Dashboard;
use Laravel\Nova\Dashboards\Main;
use Laravel\Nova\DevTool\DevTool as Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Tool;
use Opscale\NovaCatalogs\Package;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    #[\Override]
    public function boot(): void
    {
        parent::boot();

        //
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array<int, Tool>
     */
    #[\Override]
    public function tools(): array
    {
        return [
            new Package,
        ];
    }

    /**
     * Register any application services.
     */
    #[\Override]
    public function register(): void
    {
        parent::register();

        //
    }

    /**
     * Register the configurations for Laravel Fortify.
     */
    #[\Override]
    protected function fortify(): void
    {
        Nova::fortify()
            ->features([
                Features::updatePasswords(),
                // Features::emailVerification(),
                // Features::twoFactorAuthentication(['confirm' => true, 'confirmPassword' => true]),
            ])
            ->register();
    }

    /**
     * Register the Nova routes.
     */
    #[\Override]
    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes(default: true)
            ->withPasswordResetRoutes()
            ->withoutEmailVerificationRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     */
    #[\Override]
    protected function gate(): void
    {
        Gate::define('viewNova', function ($user): true {
            return true;
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array<int, Dashboard>
     */
    #[\Override]
    protected function dashboards(): array
    {
        return [
            new Main,
        ];
    }

    /**
     * Register the application's Nova resources.
     */
    #[\Override]
    protected function resources(): void
    {
        Nova::resourcesInWorkbench();
    }
}
