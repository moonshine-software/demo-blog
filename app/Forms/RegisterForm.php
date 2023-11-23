<?php

declare(strict_types=1);

namespace App\Forms;

use MoonShine\ActionButtons\ActionButton;
use MoonShine\Components\FormBuilder;
use MoonShine\Fields\Email;
use MoonShine\Fields\Password;
use MoonShine\Fields\PasswordRepeat;
use MoonShine\Fields\Text;

final class RegisterForm
{
    public static function make(): FormBuilder
    {
        return FormBuilder::make(
            route('register'),
        )->fields([
            Text::make('Name')->required(),
            Email::make('Email')->required(),
            Password::make('Password')->required(),
            PasswordRepeat::make('Password confirmation')->required(),
        ])->submit('Регистрация', ['class' => 'btn btn-primary w-full']);
    }
}
