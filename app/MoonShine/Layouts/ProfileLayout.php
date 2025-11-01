<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\ArticleResource;
use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\UserResource;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use MoonShine\UI\Components\{Components,
    Layout\Body,
    Layout\Content,
    Layout\Div,
    Layout\Flash,
    Layout\Html,
    Layout\Layout,
    Layout\Wrapper,
    Title};

final class ProfileLayout extends AppLayout
{
    protected function menu(): array
    {
        return [];
    }

    protected function getHomeUrl(): string
    {
        return '/';
    }

    public function build(): Layout
    {
        return Layout::make([
            Html::make([
                $this->getHeadComponent(),
                Body::make([
                    Wrapper::make([
                        Div::make([
                            Flash::make(),

                            $this->getHeaderComponent(),

                            Content::make([
                                Title::make($this->getPage()->getTitle())->class('mb-6'),
                                Components::make(
                                    $this->getPage()->getComponents()
                                ),
                            ]),

                            $this->getFooterComponent(),
                        ])->class('layout-page'),
                    ]),
                ]),
            ])
                ->customAttributes([
                    'lang' => $this->getHeadLang(),
                ])
                ->withAlpineJs()
                ->withThemes(),
        ]);
    }
}
