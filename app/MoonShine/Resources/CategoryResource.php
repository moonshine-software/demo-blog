<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Category;
use App\MoonShine\Pages\CategoryTreePage;
use Illuminate\Database\Eloquent\Model;
use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;


class CategoryResource extends TreeResource
{
    protected string $model = Category::class;

    protected string $title = 'Categories';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    protected bool $createInModal = true;

    protected array $with = [
        'category',
    ];

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Parent', 'category', resource: CategoryResource::class)
                ->nullable()
                ->badge(),

            Text::make('Title')
                ->updateOnPreview(),

            Slug::make('Slug')
                ->from('title')
                ->separator('-'),

            Number::make('Sorting')
                ->buttons()
                ->default(0),
        ];
    }

    public function formFields(): array
    {
        return [
            Box::make([
                ID::make()->sortable(),
                BelongsTo::make('Parent', 'category', resource: CategoryResource::class)
                    ->nullable()
                    ->badge(),

                Text::make('Title')
                    ->updateOnPreview()
                    ->required(),

                Slug::make('Slug')
                    ->from('title')
                    ->separator('-'),

                Number::make('Sorting')
                    ->buttons()
                    ->default(0),
            ]),
        ];
    }

    public function detailFields(): array
    {
        return [
            ...$this->indexFields(),
        ];
    }

    protected function pages(): array
    {
        return [
            CategoryTreePage::class,
            FormPage::class,
            DetailPage::class,
        ];
    }

    public function rules(mixed $item): array
    {
        return [
            'title' => ['required']
        ];
    }

    public function treeKey(): ?string
    {
        return 'category_id';
    }

    public function sortKey(): string
    {
        return $this->getSortColumn();
    }
}
