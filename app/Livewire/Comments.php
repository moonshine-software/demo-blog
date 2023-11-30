<?php

namespace App\Livewire;

use App\Livewire\Forms\CommentForm;
use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Comments extends Component
{
    public CommentForm $form;

    public ?Article $article;

    public function mount(Article $article): void
    {
        $this->article = $article;

        $this->form->setArticle($article);
    }

    public function answer(?int $id = null): void
    {
        $this->form->setCommentId($id);
    }

    public function store(): void
    {
        $this->form->store();
    }

    #[Computed]
    public function comments(): Collection
    {
        return $this->article->comments()
            ->whereNull('comment_id')
            ->with(['user', 'comments', 'comments.user'])
            ->get();
    }

    public function render(): View
    {
        return view('livewire.comments', [
            'comments' => $this->comments(),
        ]);
    }
}
