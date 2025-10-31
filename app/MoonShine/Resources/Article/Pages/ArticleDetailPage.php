<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Article\Pages;

use App\MoonShine\Resources\Article\ArticleResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Resources\MoonShineUserResource;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends DetailPage<ArticleResource>
 */
class ArticleDetailPage extends DetailPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            BelongsTo::make('Author', resource: MoonShineUserResource::class)
                ->badge()
                ->asyncSearch()
                ->withImage('avatar', 'public', 'moonshine_users')
            ,
            Text::make('Title'),
            Slug::make('Slug'),
            Image::make('Thumbnail')
                ->disk('public')
                ->dir('articles'),

            Switcher::make('Is published'),
        ];
    }
}
