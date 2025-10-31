<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Article;

use App\Models\Article;
use App\MoonShine\Resources\Article\Pages\ArticleDetailPage;
use App\MoonShine\Resources\Article\Pages\ArticleFormPage;
use App\MoonShine\Resources\Article\Pages\ArticleIndexPage;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Laravel\Models\MoonshineUserRole;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Article>
 */
class ArticleResource extends ModelResource
{
    protected string $model = Article::class;

    protected string $title = 'Articles';

    protected bool $withPolicy = true;

    protected array $with = [
        'author',
        'categories',
    ];

    protected function pages(): array
    {
        return [
            ArticleIndexPage::class,
            ArticleDetailPage::class,
            ArticleFormPage::class,
        ];
    }

    public function getQuery(): Builder
    {
        if(auth()->user()->moonshine_user_role_id === MoonshineUserRole::DEFAULT_ROLE_ID) {
            return parent::getQuery();
        }

        return parent::getQuery()->where('author_id', auth()->id());
    }
}
