@extends('layouts.app')

@section('content')
    <x-moonshine::grid>
        <x-moonshine::column>
            <img
                src="{{ $article->makeImage('1000x300') }}"
                class="my-4 w-full"
                alt=""
            />

            <div class="sm:flex gap-4 items-center justify-between">
                <x-moonshine::title>
                    {{ $article->title }}
                </x-moonshine::title>

                <livewire:likes :article="$article" />
            </div>

            <x-moonshine::divider />

            <div class="prose prose-2xl">
                {!! $article->description !!}
            </div>

            <livewire:comments :article="$article" />
        </x-moonshine::column>
    </x-moonshine::grid>
@endsection
