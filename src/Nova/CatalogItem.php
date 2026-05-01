<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Opscale\NovaCatalogs\Models\CatalogItem as Model;

/**
 * @extends Resource<Model>
 */
class CatalogItem extends Resource
{
    /** @var class-string<Model> */
    public static $model = Model::class;

    public static $title = 'name';

    /** @var array<int, string> */
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

    final public static function label(): string
    {
        return __('Items');
    }

    final public static function singularLabel(): string
    {
        return __('Item');
    }

    final public static function uriKey(): string
    {
        return __('catalog-items');
    }

    /**
     * @return array<int, Field>
     */
    final public function fields(NovaRequest $request): array
    {
        return array_values($this->defaultFields($request));
    }

    /**
     * @return array<string, Field>
     */
    final protected function defaultFields(NovaRequest $request): array
    {
        /** @var Model $model */
        $model = $this->model();
        $rules = $model->validationRules();

        return [
            'catalog' => BelongsTo::make(__('Catalog'), 'catalog', Catalog::class)
                ->sortable()
                ->filterable(),

            'name' => Text::make(__('Name'), 'name')
                ->required()
                ->rules($rules['name'])
                ->sortable(),

            'key' => Slug::make(__('Key'), 'key')
                ->from('name')
                ->separator('-')
                ->required()
                ->rules($rules['key'])
                ->sortable(),

            'description' => Textarea::make(__('Description'), 'description')
                ->rules($rules['description'])
                ->nullable(),

            'data' => KeyValue::make(__('Data'), 'data')
                ->rules($rules['data'])
                ->keyLabel('Key')
                ->valueLabel('Value')
                ->actionText('Add Item')
                ->onlyOnDetail(),
        ];
    }
}
