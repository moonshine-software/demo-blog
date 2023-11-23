<?php

use App\MoonShine\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/actions/user/login-by', UserController::class)
    ->name('login-by');
