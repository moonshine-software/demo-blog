<?php

use function Livewire\Volt\{state};

state([
    'article' => null,
    'count' => fn() => $this->article->likes->count(),
    'liked' => fn() => $this->article->likes->first(fn($like) => $like->user_id === auth()->id())
]);

$like = function () {
    $this->liked = true;

    $like = $this->article->likes()->firstOrCreate([
        'user_id' => auth()->id(),
    ]);

    if(!$like->wasRecentlyCreated) {
        $like->delete();
        $this->count--;
        $this->liked = false;
    } else {
        $this->count++;
    }
};
?>

<a wire:click="like" class="flex gap-4 items-center justify-between">
    <x-moonshine::icon :icon="$liked ? 'heroicons.heart' : 'heroicons.outline.heart'" size="10" />
    <span class="font-bold">{{ $count }}</span>
</a>
