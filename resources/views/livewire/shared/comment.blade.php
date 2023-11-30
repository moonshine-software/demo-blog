<div wire:key="{{ $comment->id }}" class="flex items-center space-x-4 grow my-4"
    @if($comment->comment_id) style="margin-left: 50px;" @endif
>
    <img src="https://ui-avatars.com/api/?name={{ $comment->user->name }}"
         class="rounded-full w-12 h-12 align-middle border-none m-0"
         alt="{{ $comment->user->name }}"
    >
    <div>
        <div class="font-bold">{{ $comment->user->name }}</div>
        <div class="text-xs font-normal">{{ $comment->created_at->format('d.m.Y H:i') }}</div>
        <div class="text-sm mt-2 break-words">{{ $comment->text }}</div>

        @if($comment->comment_id === null)
            <div class="text-sm mt-2">
                <x-moonshine::link-button wire:click="answer({{$comment->id}})">
                    Ответить
                </x-moonshine::link-button>
            </div>
        @endif
    </div>
</div>
