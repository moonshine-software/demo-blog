<?php

declare(strict_types=1);

namespace App\Traits\Models;

use App\Models\Like;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin Model
 */
trait HasLikes
{
    public function scopeWithLikes(Builder $query): void
    {
        $query->withCount('likes');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
