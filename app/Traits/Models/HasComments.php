<?php

declare(strict_types=1);

namespace App\Traits\Models;

use App\Models\Comment;
use App\Models\Like;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin Model
 */
trait HasComments
{
    public function scopeWithComments(Builder $query): void
    {
        $query
            ->with(['comments', 'comments.user', 'comments.comments', 'comments.comments.user'])
            ->withCount('comments');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->latest();
    }
}
