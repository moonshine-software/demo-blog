<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', HomeController::class)->name('home');

Route::get('/profile', ProfileController::class)->name('profile');

Route::controller(ArticleController::class)
    ->name('articles.')
    ->prefix('articles')->group(function () {
        Route::get('/{slug?}', 'index')->name('index');

        Route::post('/likes', LikesController::class)
            ->middleware('auth')
            ->middleware(['auth', 'throttle:20,1,likes'])
            ->name('likes');

        Route::post('/comment', CommentController::class)
            ->middleware(['auth', 'throttle:5,1,comments'])
            ->name('comment');
    });

Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('web.logout');
