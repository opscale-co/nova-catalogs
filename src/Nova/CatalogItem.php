<?php

namespace Opscale\NovaCatalogs\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Opscale\NovaCatalogs\Models\CatalogItem as Model;

class CatalogItem extends Resource
{
    public static $model = Model::class;

    public static $title = 'name';

    public static $search = [
        'name',
        'key',
    ];

    public static function label()
    {
        return __('Items');
    }

    public static function singularLabel()
    {
        return __('Item');
    }

    public static function uriKey()
    {
        return __('catalog-items');
    }

    public function fields(NovaRequest $request)
    {
        return [
            'catalog' => BelongsTo::make(_('Catalog'), 'catalog', Catalog::class)
                ->sortable()
                ->filterable(),

            'name' => Text::make(_('Name'), 'name')
                ->required()
                ->rules($this->model()?->validationRules['name'])
                ->sortable(),

            'key' => Slug::make(_('Key'), 'key')
                ->from('name')
                ->separator('-')
                ->required()
                ->rules($this->model()?->validationRules['key'])
                ->sortable(),

            'metadata' => KeyValue::make(__('Metadata'), 'metadata')
                ->rules($this->model()?->validationRules['metadata'])
                ->keyLabel('Key')
                ->valueLabel('Value')
                ->actionText('Add Item')
                ->exceptOnForms(),
        ];
    }
}
