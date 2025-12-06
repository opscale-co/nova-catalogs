<?php

namespace Opscale\NovaCatalogs\Nova;

use Illuminate\Support\Collection;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Laravel\Nova\Resource;
use Laravel\Nova\Tabs\Tab;
use Opscale\NovaCatalogs\Concerns\Catalogable;
use Opscale\NovaCatalogs\Models\Catalog as Model;

class Catalog extends Resource
{
    public static $model = Model::class;

    public static $title = 'name';

    public static $search = [
        'name',
        'key',
        'description',
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
            Tab::group('Catalog', [
                Tab::make('Details', [
                    'catalogable' => MorphTo::make(__('Parent'), 'catalogable')
                        ->types($this->getCatalogableResources())
                        ->nullable()
                        ->searchable()
                        ->hideWhenCreating(),

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
                        ->rules($this->model()?->validationRules['description']),

                    'metadata' => KeyValue::make(__('Metadata'), 'metadata')
                        ->rules($this->model()?->validationRules['metadata'])
                        ->keyLabel('Key')
                        ->valueLabel('Value')
                        ->actionText('Add Item')
                        ->exceptOnForms(),
                ]),

                Tab::make('Items', [
                    'items' => HasMany::make(__('Items'), 'items', CatalogItem::class),
                ]),
            ]),
        ];
    }

    /**
     * Get all Nova resources whose models use the Catalogable trait.
     *
     * @return array<class-string<\Laravel\Nova\Resource<\Illuminate\Database\Eloquent\Model>>, string>
     */
    private function getCatalogableResources(): array
    {
        /** @var array<class-string<\Laravel\Nova\Resource<\Illuminate\Database\Eloquent\Model>>, string> $resources */
        $resources = (new Collection(Nova::$resources))
            ->filter(function (string $resource): bool {
                /** @var class-string<\Laravel\Nova\Resource> $resource */
                /** @var class-string<\Illuminate\Database\Eloquent\Model> $model */
                $model = $resource::$model;
                $traits = class_uses_recursive($model);

                return in_array(Catalogable::class, $traits ?: [], true);
            })
            ->toArray();

        return $resources;
    }
}
