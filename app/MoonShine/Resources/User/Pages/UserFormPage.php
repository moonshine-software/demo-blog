<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\User\Pages;

use App\MoonShine\Resources\User\UserResource;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\PasswordRepeat;
use MoonShine\UI\Fields\Text;

/**
 * @extends FormPage<UserResource>
 */
class UserFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
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

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'password' => ['confirmed']
        ];
    }
}
