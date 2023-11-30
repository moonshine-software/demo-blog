<div>
    <x-moonshine::divider label="Комментарии" />

    <x-moonshine::form name="comments" wire:submit="store">
        <x-moonshine::form.textarea name="message" wire:model="form.message" />

        <x-moonshine::form.button type="submit">
            {{ $form->commentId ? 'Ответить' : 'Написать' }}
        </x-moonshine::form.button>
        
        @if($form->commentId)
            <x-moonshine::link-button wire:click="answer">
                X
            </x-moonshine::link-button>
        @endif
    </x-moonshine::form>

    @foreach($comments as $comment)
        @include('livewire.shared.comment', ['comment' => $comment])

        @if($comment->comments->isNotEmpty())
            <x-moonshine::divider />

            @foreach($comment->comments as $child)
                @include('livewire.shared.comment', ['comment' => $child])
            @endforeach
        @endif
    @endforeach
</div>
