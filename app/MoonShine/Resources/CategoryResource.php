<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Category;
use App\MoonShine\Pages\CategoryTreePage;
use Illuminate\Database\Eloquent\Model;
use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Text;
use MoonShine\Pages\Crud\DetailPage;
use MoonShine\Pages\Crud\FormPage;

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

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                BelongsTo::make('Parent', 'category', resource: new CategoryResource())
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

    protected function pages(): array
    {
        return [
            CategoryTreePage::make($this->title()),
            FormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            DetailPage::make(__('moonshine::ui.show')),
        ];
    }

    public function rules(Model $item): array
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
        return $this->sortColumn();
    }
}
