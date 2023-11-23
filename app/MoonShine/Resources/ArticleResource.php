<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article;

use MoonShine\ActionButtons\ActionButton;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Slug;
use MoonShine\Fields\StackFields;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Resources\MoonShineUserResource;

class ArticleResource extends ModelResource
{
    protected string $model = Article::class;

    protected string $title = 'Articles';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    protected bool $withPolicy = true;

    protected array $with = [
        'author',
        'categories'
    ];

    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make('Main information', [
                        ID::make()->sortable(),
                        BelongsTo::make('Author', resource: new MoonShineUserResource())
                            ->badge()
                            ->asyncSearch()
                            ->withImage('avatar', 'public', 'moonshine_users')
                        ,

                        StackFields::make('Title')->fields([
                            Text::make('Title')->required(),
                            Slug::make('Slug')
                                ->from('title')
                                ->separator('-'),
                        ]),

                        TinyMce::make('Description')->required()->hideOnIndex(),

                        Image::make('Thumbnail')
                            ->disk('public')
                            ->dir('articles'),

                        Switcher::make('Is published')
                            ->updateOnPreview(),
                    ]),
                ])->columnSpan(8),
                Column::make([
                    Block::make('Categories', [
                        BelongsToMany::make('Categories')
                            ->hideOnIndex()
                            ->tree('category_id')
                    ]),
                ])->columnSpan(4)
            ])
        ];
    }

    public function query(): Builder
    {
        return parent::query()->where('author_id', auth()->id());
    }

    public function rules(Model $item): array
    {
        return [
            'title' => ['required'],
            'description' => ['required'],
        ];
    }

    public function buttons(): array
    {
        return [
            ActionButton::make('Go to article', fn(Article $data) => route('articles.index', $data->slug))
                ->primary()
        ];
    }
}
