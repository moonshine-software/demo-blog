<?php

declare(strict_types=1);

namespace App\MoonShine\Controllers;

use MoonShine\Contracts\Core\DependencyInjection\CrudRequestContract;
use MoonShine\Laravel\Http\Controllers\MoonShineController;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends MoonshineController
{
    public function __invoke(CrudRequestContract $request): Response
    {
        auth('web')->loginUsingId($request->get('user_id'));

        $request->session()->regenerate();

        return to_route('home');
    }
}
