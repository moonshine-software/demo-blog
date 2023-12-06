<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\ArticleResource;
use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\UserResource;
use Closure;
use Illuminate\Support\Facades\Vite;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\MoonShineRequest;
use MoonShine\Providers\MoonShineApplicationServiceProvider;

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

    protected function menu(): Closure
    {
        return static function (MoonShineRequest $request) {
            if(!$request->isMoonShineRequest()) {
                return [
                    MenuItem::make('Статьи', static fn () => route('articles.index')),
                ];
            }

            return [
                MenuGroup::make(static fn () => __('moonshine::ui.resource.system'), [
                    MenuItem::make(
                        static fn () => __('moonshine::ui.resource.admins_title'),
                        new MoonShineUserResource()
                    ),
                    MenuItem::make(
                        static fn () => __('moonshine::ui.resource.role_title'),
                        new MoonShineUserRoleResource()
                    ),
                ]),

                MenuGroup::make('Статьи', [
                    MenuItem::make(
                        'Категории',
                        new CategoryResource()
                    ),
                    MenuItem::make(
                        'Статьи',
                        new ArticleResource()
                    ),
                ]),

                MenuItem::make('Пользователи', new UserResource())
                    ->icon('heroicons.outline.users'),

                MenuItem::make('Сайт', static fn () => route('home')),
            ];
        };
    }

    protected function theme(): Closure
    {
        return static function (MoonShineRequest $request) {
            return ! $request->isMoonShineRequest() ? [
                'colors' => [
                    'primary' => '#1D8A99',
                    'secondary' => '#1E96FC',
                ],
            ] : [];
        };
    }
}
