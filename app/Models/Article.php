<?php

namespace App\Models;

use App\Traits\Models\HasComments;
use App\Traits\Models\HasGeneratedImage;
use App\Traits\Models\HasLikes;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use MoonShine\Models\MoonshineUser;

class Article extends Model
{
    use HasFactory;
    use HasGeneratedImage;
    use HasComments;
    use HasLikes;

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'slug',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'bool',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('slug', $value)
            ->detail()
            ->firstOrFail();
    }

    protected function imageDir(): string
    {
        return 'articles';
    }

    protected function imageColumn(): string
    {
        return 'thumbnail';
    }

    public function scopeDetail(Builder $query): void
    {
        $query->with(['categories', 'author'])
            ->withComments()
            ->withLikes()
            ->published()
        ;
    }

    public function scopePublished(Builder $query): void
    {
        $query->whereIsPublished(true);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(MoonshineUser::class);
    }
}
