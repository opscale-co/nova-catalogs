<?php

namespace Opscale\NovaCatalogs;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool as NovaTool;
use Opscale\NovaCatalogs\Nova\Catalog;

class Tool extends NovaTool
{
    public function boot()
    {
        Nova::script('nova-catalogs', __DIR__ . '/../dist/js/tool.js');
        Nova::style('nova-catalogs', __DIR__ . '/../dist/css/tool.css');
    }

    public function menu(Request $request)
    {
        return MenuItem::resource(Catalog::class);
    }
}
