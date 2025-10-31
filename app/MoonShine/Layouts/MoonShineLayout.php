<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\Article\ArticleResource;
use App\MoonShine\Resources\Category\CategoryResource;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{
    protected function menu(): array
    {
        return [
            ...parent::menu(),
            MenuGroup::make('Статьи', [
                MenuItem::make(
                    CategoryResource::class,
                    'Категории',
                ),
                MenuItem::make(
                    ArticleResource::class,
                    'Статьи',
                ),
            ]),
            MenuItem::make(UserResource::class, 'Пользователи')
                ->icon('users'),

            MenuItem::make(static fn () => route('home'), 'Сайт')->blank(),
        ];
    }
}
