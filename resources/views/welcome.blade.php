@extends('layouts.app')

@section('content')
    <x-moonshine::grid>
        @foreach($articles as $article)
            <x-moonshine::column colSpan="4">
                <x-moonshine::card
                    :url="route('articles.index', $article->slug)"
                    :overlay="true"
                    :thumbnail="$article->makeImage('500x300')"
                    :title="$article->title"
                    :subtitle="$article->created_at?->format('d.m.Y')"
                    :values="['Автор' => $article->author?->name ?? '-']"
                >
                    {!! $article->description !!}

                    <x-slot:actions>
                        <x-moonshine::link-button :href="route('articles.index', $article->slug)">
                            Подробнее
                        </x-moonshine::link-button>
                    </x-slot:actions>
                </x-moonshine::card>
            </x-moonshine::column>
        @endforeach
    </x-moonshine::grid>
@endsection
