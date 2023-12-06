<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\ArticleResource;
use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\UserResource;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Vite;
use MoonShine\MoonShineRequest;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use MoonShine\MoonShine;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        moonshineAssets()->add([
            Vite::asset('resources/css/app.css'),
            Vite::asset('resources/js/app.js'),
        ]);
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make(static fn() => __('moonshine::ui.resource.system'), [
               MenuItem::make(
                   static fn() => __('moonshine::ui.resource.admins_title'),
                   new MoonShineUserResource()
               ),
               MenuItem::make(
                   static fn() => __('moonshine::ui.resource.role_title'),
                   new MoonShineUserRoleResource()
               ),
            ])->canSee(fn(MoonShineRequest $request) => $request->isMoonShineRequest()),

            MenuGroup::make('Статьи', [
                MenuItem::make(
                    'Категории',
                    new CategoryResource()
                ),
                MenuItem::make(
                    'Статьи',
                    new ArticleResource()
                ),
            ])->canSee(fn(MoonShineRequest $request) => $request->isMoonShineRequest()),

            MenuItem::make('Пользователи', new UserResource())
                ->icon('heroicons.outline.users')
                ->canSee(fn(MoonShineRequest $request) => $request->isMoonShineRequest()),

            MenuItem::make('Статьи', fn() => route('articles.index'))
                ->canSee(fn(MoonShineRequest $request) => !$request->isMoonShineRequest()),

            MenuItem::make('Сайт', fn() => route('home'))
                ->canSee(fn(MoonShineRequest $request) => $request->isMoonShineRequest()),
        ];
    }

    /**
     * @return array{css: string, colors: array, darkColors: array}
     */
    protected function theme(): array
    {
        return [];
    }
}
