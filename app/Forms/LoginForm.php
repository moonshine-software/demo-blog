<?php

declare(strict_types=1);

namespace App\Forms;

use MoonShine\ActionButtons\ActionButton;
use MoonShine\Components\FormBuilder;
use MoonShine\Fields\Email;
use MoonShine\Fields\Password;

final class LoginForm
{
    public static function make(): FormBuilder
    {
        return FormBuilder::make(
            route('login'),
        )->fields([
            Email::make('Email')->required(),
            Password::make('Password')->required()
        ])->submit('Войти', ['class' => 'btn btn-primary w-full']);
    }
}
