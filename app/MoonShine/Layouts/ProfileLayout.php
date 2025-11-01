<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\UI\Components\{
    Layout\Body,
    Layout\Content,
    Layout\Div,
    Layout\Flash,
    Layout\Html,
    Layout\Layout,
    Layout\Wrapper};

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

                            Content::make($this->getContentComponents()),

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
