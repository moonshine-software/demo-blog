<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Article;
use MoonShine\Contracts\UI\ActionButtonContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Models\MoonshineUserRole;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\DateRange;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\StackFields;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

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

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Author', resource: MoonShineUserResource::class)
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
            Image::make('Thumbnail')
                ->disk('public')
                ->dir('articles'),

            Switcher::make('Is published')
                ->updateOnPreview(),
        ];
    }


    public function formFields(): iterable
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

                        StackFields::make('Title')->fields([
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

    public function detailFields(): iterable
    {
        return [
            ...$this->indexFields(),
        ];
    }

    public function getQuery(): Builder
    {
        if(auth()->user()->moonshine_user_role_id === MoonshineUserRole::DEFAULT_ROLE_ID) {
            return parent::getQuery();
        }

        return parent::getQuery()->where('author_id', auth()->id());
    }

    public function rules(mixed $item): array
    {
        return [
            'title' => ['required'],
            'description' => ['required'],
        ];
    }

    public function indexButtons(): ListOf
    {
        return new ListOf(ActionButtonContract::class, [
            ActionButton::make('Go to article', fn(Article $data) => route('articles.index', $data->slug))
                ->primary(),
            ...parent::indexButtons()->toArray(),
        ]);
    }

    public function filters(): array
    {
        return [
            DateRange::make('Created at')->withTime(),
        ];
    }
}
