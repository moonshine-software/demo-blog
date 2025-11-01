<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Article\Pages;

use App\Models\Article;
use App\MoonShine\Resources\Article\ArticleResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Resources\MoonShineUserResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\ActionButton;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\DateRange;
use MoonShine\UI\Fields\Fieldset;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<ArticleResource>
 */
class ArticleIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Author', resource: MoonShineUserResource::class)
                ->badge()
                ->asyncSearch()
                ->withImage('avatar', 'public', 'moonshine_users')
            ,
            Fieldset::make('Title')->fields([
                Text::make('Title'),
                Slug::make('Slug'),
            ]),
            Image::make('Thumbnail')
                ->disk('public')
                ->dir('articles'),

            Switcher::make('Is published')
                ->updateOnPreview(),
        ];
    }

    protected function modifyListComponent(ComponentContract $component): TableBuilder
    {
        return $component->clickAction(ClickAction::EDIT);
    }

    protected function buttons(): ListOf
    {
        return parent::buttons()
            ->prepend(
                ActionButton::make('Go to article', static fn(Article $data) => route('articles.index', $data->slug))
                    ->primary()
                    ->blank()
            );
    }

    /**
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [
            DateRange::make('Created at')->withTime(),
        ];
    }
}
