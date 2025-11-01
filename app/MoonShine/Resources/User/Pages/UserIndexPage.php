<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\User\Pages;

use App\Models\User;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\HiddenIds;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<UserResource>
 */
class UserIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Name'),
            Email::make('Email'),
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons()
            ->prepend(
                ActionButton::make(
                    'Войти',
                    fn(User $user) => route('login-by', ['user_id' => $user->getKey()])
                )
            );
    }

    protected function topLeftButtons(): ListOf
    {
        return parent::topLeftButtons()
            ->add(
                ActionButton::make('Button', '/')
                    ->inModal('Modal', (string) FormBuilder::make()->fields([
                        HiddenIds::make($this->getListComponentName())
                    ]))
            );
    }
}
