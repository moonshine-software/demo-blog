<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        $articles = Article::query()
            ->with(['categories', 'author'])
            ->withComments()
            ->withLikes()
            ->published()
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('articles'));
    }
}
