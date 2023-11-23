<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

use Illuminate\Support\Facades\Route;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Components\FormBuilder;
use MoonShine\Decorations\Collapse;
use MoonShine\Fields\Email;
use MoonShine\Fields\HiddenIds;
use MoonShine\Fields\Password;
use MoonShine\Fields\PasswordRepeat;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;

class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Users';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Name'),
                Email::make('Email'),

                Collapse::make('Password')->fields([
                    Password::make('Password')
                        ->customAttributes([
                            'autocomplete' => 'new-password'
                        ])
                        ->hideOnIndex()
                        ->hideOnDetail()
                        ->eye(),
                    PasswordRepeat::make('Password confirmation')
                        ->hideOnIndex()
                        ->hideOnDetail()
                        ->eye()
                ])
            ]),
        ];
    }

    public function actions(): array
    {
        return [
            ActionButton::make('Button', '/')
                ->inModal('Modal', (string) FormBuilder::make()->fields([
                    HiddenIds::make()
                ]))
        ];
    }

    public function indexButtons(): array
    {
        return [
            ActionButton::make(
                'Войти',
                fn(User $user) => route('login-by', ['user_id' => $user->getKey()])
            )
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'password' => ['confirmed']
        ];
    }
}
