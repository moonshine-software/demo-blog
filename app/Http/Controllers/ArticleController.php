<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;

class ArticleController extends Controller
{
    public function index(?string $slug = null): View
    {
        $category = null;

        if ($slug) {
            $article = Article::query()
                ->detail()
                ->where('slug', $slug)
                ->first();

            if ($article) {
                return $this->show($article);
            }

            $category = Category::query()
                ->where('slug', $slug)
                ->firstOrFail();
        }

        $categories = Category::query()
            ->select(['id', 'title', 'slug'])
            ->get();

        $articles = Article::query()
            ->with(['categories', 'author'])
            ->when($category, fn (Builder $query) => $query->whereRelation(
                'categories',
                'categories.id',
                '=', $category->getKey()
            ))
            ->withComments()
            ->withLikes()
            ->published()
            ->latest()
            ->paginate(3);

        return view('articles.index', [
            'category' => $category,
            'articles' => $articles,
            'categories' => $categories
        ]);
    }

    public function show(Article $article): View
    {
        return view('articles.show', [
            'article' => $article
        ]);
    }
}
