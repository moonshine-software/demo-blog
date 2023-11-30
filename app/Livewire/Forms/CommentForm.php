<?php

namespace App\Livewire\Forms;

use App\Models\Article;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CommentForm extends Form
{
    public ?Article $article;

    public ?int $commentId = null;

    #[Validate('required|min:5')]
    public $message = '';

    public function setArticle(Article $article): void
    {
        $this->article = $article;
    }

    public function setCommentId(?int $commentId = null): void
    {
        $this->commentId = $commentId;
    }

    public function store(): void
    {
        $this->validate();

        $this->article->comments()->create([
            'user_id' => auth()->id(),
            'comment_id' => $this->commentId,
            'text' => $this->message,
        ]);

        $this->reset(['message', 'commentId']);
    }
}
