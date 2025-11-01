<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Article\Pages;

use App\MoonShine\Resources\Article\ArticleResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Resources\MoonShineUserResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Fieldset;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends FormPage<ArticleResource>
 */
class ArticleFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Grid::make([
                Column::make([
                    Box::make('Main information', [
                        ID::make()->sortable(),
                        BelongsTo::make('Author', resource: MoonShineUserResource::class)
                            ->badge()
                            ->asyncSearch()
                            ->withImage('avatar', 'public', 'moonshine_users')
                        ,

                        Fieldset::make('Title')->fields([
                            Text::make('Title')->required(),
                            Slug::make('Slug')
                                ->from('title')
                                ->separator('-'),
                        ]),

                        Textarea::make('Description')->required(),

                        Image::make('Thumbnail')
                            ->disk('public')
                            ->dir('articles'),

                        Switcher::make('Is published')
                            ->updateOnPreview(),
                    ]),
                ])->columnSpan(8),
                Column::make([
                    Box::make('Categories', [
                        BelongsToMany::make('Categories')
                            ->tree('category_id')
                    ]),
                ])->columnSpan(4)
            ])
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'title' => ['required', 'min:10'],
            'description' => ['required', 'min:20'],
        ];
    }
}
