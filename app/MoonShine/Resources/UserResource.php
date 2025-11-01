<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\User;
use MoonShine\Contracts\UI\ActionButtonContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\HiddenIds;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\PasswordRepeat;
use MoonShine\UI\Fields\Text;


class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Users';

    public function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Name'),
            Email::make('Email'),
        ];
    }

    public function formFields(): iterable
    {
        return [
            Box::make([
                ID::make()->sortable(),
                Text::make('Name'),
                Email::make('Email'),

                Collapse::make('Password', [
                    Password::make('Password')
                        ->customAttributes([
                            'autocomplete' => 'new-password'
                        ])
                        ->eye(),
                    PasswordRepeat::make('Password confirmation')
                        ->eye()
                ])
            ]),
        ];
    }

    public function detailFields(): iterable
    {
        return [
            ...$this->indexFields(),
        ];
    }

    protected function topButtons(): ListOf
    {
        return parent::topButtons()->add(
            ActionButton::make('Button', '/')
                ->inModal('Modal', (string) FormBuilder::make()->fields([
                    HiddenIds::make($this->getIndexPage()->getListComponentName())
                ]))
        );
    }

    public function indexButtons(): ListOf
    {
        return new ListOf(ActionButtonContract::class, [
            ActionButton::make(
                'Войти',
                fn(User $user) => route('login-by', ['user_id' => $user->getKey()])
            ),
            ...parent::indexButtons()->toArray(),
        ]);
    }

    public function rules(mixed $item): array
    {
        return [
            'password' => ['confirmed']
        ];
    }
}
