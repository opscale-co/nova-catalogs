<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool as NovaTool;
use Opscale\NovaCatalogs\Nova\Catalog;

class Package extends NovaTool
{
    #[\Override]
    public function boot(): void
    {
        parent::boot();

        Nova::script('nova-catalogs', __DIR__.'/../dist/js/tool.js');
        Nova::style('nova-catalogs', __DIR__.'/../dist/css/tool.css');
    }

    #[\Override]
    public function menu(Request $request): MenuItem
    {
        return MenuItem::resource(Catalog::class);
    }
}
