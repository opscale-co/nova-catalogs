<?php

namespace Opscale\NovaCatalogs;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool as NovaTool;
use Opscale\NovaCatalogs\Nova\Catalog;
use Opscale\NovaCatalogs\Nova\CatalogItem;

class Tool extends NovaTool
{
    public function boot()
    {
        Nova::script('nova-catalogs', __DIR__ . '/../dist/js/tool.js');
        Nova::style('nova-catalogs', __DIR__ . '/../dist/css/tool.css');
        $this->loadResources();
    }

    public function menu(Request $request)
    {
        return MenuSection::make('Catalogs', [
            MenuItem::make(Catalog::label(), Catalog::class)->path('/resources/' . Catalog::uriKey()),
            MenuItem::make(CatalogItem::label(), CatalogItem::class)->path('/resources/' . CatalogItem::uriKey()),
        ])->collapsable()
        ->icon('folder-open');
    }

    protected function loadResources()
    {
        Nova::resources([
            Catalog::class,
            CatalogItem::class,
        ]);
    }
}
