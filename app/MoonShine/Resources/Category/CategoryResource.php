<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Category;

use App\Models\Category;
use App\MoonShine\Resources\Category\Pages\CategoryDetailPage;
use App\MoonShine\Resources\Category\Pages\CategoryFormPage;
use App\MoonShine\Resources\Category\Pages\CategoryTreePage;
use Leeto\MoonShineTree\Resources\TreeResource;

/**
 * @extends TreeResource<Category>
 */
class CategoryResource extends TreeResource
{
    protected string $model = Category::class;

    protected string $title = 'Categories';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    protected bool $createInModal = true;

    protected array $with = ['category'];

    protected function pages(): array
    {
        return [
            CategoryTreePage::class,
            CategoryFormPage::class,
            CategoryDetailPage::class,
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
