<?php

declare(strict_types=1);

namespace App\Pages;

use App\Models\User;
use MoonShine\Components\FormBuilder;
use MoonShine\Components\Layout\Flash;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Fields\Email;
use MoonShine\Fields\Hidden;
use MoonShine\Fields\Password;
use MoonShine\Fields\PasswordRepeat;
use MoonShine\Fields\Text;
use MoonShine\Pages\Page;
use MoonShine\TypeCasts\ModelCast;

final class ProfilePage extends Page
{
    protected string $title = 'Profile';

    protected string $layout = 'layouts.app';

    public function breadcrumbs(): array
    {
        return [
            '/profile' => 'Профиль'
        ];
    }

    public function components(): array
    {
        return [
            Block::make([
                Flash::make('status'),

                Tabs::make([
                    Tab::make('Information', [
                        FormBuilder::make(route('user-profile-information.update'))
                            ->name('updateProfileInformation')
                            ->async()
                            ->fields([
                                Hidden::make('_method')->setValue('PUT'),

                                Text::make('Name')->required(),
                                Email::make('Email')->required()
                            ])
                            ->fillCast(auth()->user(), ModelCast::make(User::class))
                            ->submit('Update')
                    ])->when(
                        session('errors')
                            ?->getBag('updateProfileInformation')
                            ?->isNotEmpty(),
                        fn(Tab $tab) => $tab->active()
                    ),

                    Tab::make('Change password', [
                        FormBuilder::make(route('user-password.update'))
                            ->name('updatePassword')
                            ->fields([
                                Hidden::make('_method')->setValue('PUT'),

                                Password::make('Current password')
                                    ->customAttributes([
                                        'autocomplete' => 'off'
                                    ])
                                    ->required(),

                                Password::make('Password')->required(),
                                PasswordRepeat::make('Password confirmation')->required(),
                            ])
                            ->submit('Update password')
                    ])->when(
                        session('errors')
                            ?->getBag('updatePassword')
                            ?->isNotEmpty(),
                        fn(Tab $tab) => $tab->active()
                    )
                ])
            ])
        ];
    }
}
