<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs\Nova;

use Illuminate\Support\Collection;
use Laravel\Nova\Fields\Field;
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
use Opscale\NovaCatalogs\Models\Catalog as Model;
use Opscale\NovaCatalogs\Models\Concerns\Catalogable;

/**
 * @extends resource<Model>
 */
class Catalog extends Resource
{
    /** @var class-string<Model> */
    public static $model = Model::class;

    public static $title = 'name';

    /** @var array<int, string> */
    public static $search = [
        'name',
        'key',
        'description',
    ];

    #[\Override]
    final public static function label(): string
    {
        return __('Catalogs');
    }

    #[\Override]
    final public static function singularLabel(): string
    {
        return __('Catalog');
    }

    #[\Override]
    final public static function uriKey(): string
    {
        return __('catalogs');
    }

    /**
     * @return array<int, mixed>
     */
    final public function fields(NovaRequest $request): array
    {
        return [
            Tab::group('Catalog', [
                Tab::make('Details', array_values($this->defaultFields($request))),

                Tab::make('Items', [
                    HasMany::make(__('Items'), 'items', CatalogItem::class),
                ]),
            ]),
        ];
    }

    /**
     * @return array<string, Field>
     */
    final protected function defaultFields(NovaRequest $novaRequest): array
    {
        /** @var Model $model */
        $model = $this->model();
        $rules = $model->validationRules();

        return [
            'catalogable' => MorphTo::make(__('Parent'), 'catalogable')
                ->types($this->getCatalogableResources())
                ->nullable()
                ->searchable()
                ->hideWhenCreating(),

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
                ->alwaysShow()
                ->rules($rules['description']),

            'data' => KeyValue::make(__('Data'), 'data')
                ->rules($rules['data'])
                ->keyLabel('Key')
                ->valueLabel('Value')
                ->actionText('Add Item')
                ->onlyOnDetail(),
        ];
    }

    /**
     * Get all Nova resources whose models use the Catalogable trait.
     *
     * @return array<class-string<resource<\Illuminate\Database\Eloquent\Model>>, string>
     */
    final protected function getCatalogableResources(): array
    {
        /** @var array<class-string<resource<\Illuminate\Database\Eloquent\Model>>, string> $resources */
        $resources = (new Collection(Nova::$resources))
            ->filter(static function (string $resource): bool {
                /** @var class-string<resource<\Illuminate\Database\Eloquent\Model>> $resource */
                /** @var class-string<\Illuminate\Database\Eloquent\Model> $model */
                $model = $resource::$model;
                $traits = class_uses_recursive($model);

                return in_array(Catalogable::class, $traits, true);
            })
            ->all();

        return $resources;
    }
}
