<?php

namespace Opscale\NovaCatalogs\Nova;

use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Opscale\NovaCatalogs\Models\Catalog as Model;

class Catalog extends Resource
{
    public static $model = Model::class;

    public static $title = 'name';

    public static $search = [
        'name',
        'description',
        'slug',
    ];

    public static function label()
    {
        return __('Catalogs');
    }

    public static function singularLabel()
    {
        return __('Catalog');
    }

    public static function uriKey()
    {
        return __('catalogs');
    }

    public function fields(NovaRequest $request)
    {
        return [
            Text::make(_('Name'), 'name')
                ->required()
                ->rules(Model::rules('name'))
                ->sortable(),

            Textarea::make(_('Description'), 'description')
                ->rules(Model::rules('description')),

            Slug::make(_('Identifier'), 'slug')
                ->from('name')
                ->separator('_')
                ->required()
                ->rules(Model::rules('slug'))
                ->sortable(),

            HasMany::make(_('Items'), 'items', CatalogItem::class),
        ];
    }
}
