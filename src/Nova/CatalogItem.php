<?php

namespace Opscale\NovaCatalogs\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
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

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

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
        return array_values($this->defaultFields($request));
    }

    protected function defaultFields(NovaRequest $request)
    {
        return [
            'catalog' => BelongsTo::make(__('Catalog'), 'catalog', Catalog::class)
                ->sortable()
                ->filterable(),

            'name' => Text::make(__('Name'), 'name')
                ->required()
                ->rules($this->model()?->validationRules['name'])
                ->sortable(),

            'key' => Slug::make(__('Key'), 'key')
                ->from('name')
                ->separator('-')
                ->required()
                ->rules($this->model()?->validationRules['key'])
                ->sortable(),

            'description' => Textarea::make(__('Description'), 'description')
                ->rules($this->model()?->validationRules['description'])
                ->nullable(),

            'data' => KeyValue::make(__('Data'), 'data')
                ->rules($this->model()?->validationRules['data'])
                ->keyLabel('Key')
                ->valueLabel('Value')
                ->actionText('Add Item')
                ->onlyOnDetail(),
        ];
    }
}
