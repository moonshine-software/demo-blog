@extends('layouts.app')

@section('content')
    <x-moonshine::grid>
        <x-moonshine::column>
            <img
                src="{{ $article->makeImage('1000x300') }}"
                class="my-4 w-full"
            />

            <div class="sm:flex gap-4 items-center justify-between">
                <x-moonshine::title>
                    {{ $article->title }}
                </x-moonshine::title>

                <a href="#" class="flex gap-4 items-center justify-between">
                    <x-moonshine::icon icon="heroicons.outline.heart" size="10" />
                    <x-moonshine::icon icon="heroicons.heart" size="10" />
                    <span class="font-bold">1</span>
                </a>
            </div>


            <x-moonshine::divider />

            <div class="prose">
                {!! $article->description !!}
            </div>

            <div>
                <x-moonshine::divider label="Комментарии" />

                <x-moonshine::form name="comments">
                    <x-moonshine::form.textarea name="message" />

                    <x-moonshine::form.button type="submit">Отправить</x-moonshine::form.button>
                </x-moonshine::form>

                <div class="flex items-center space-x-4 grow my-4">
                    <img src="https://ui-avatars.com/api/?name=DS"
                         class="rounded-full w-12 h-12 align-middle border-none m-0"
                         alt="DS"
                    >
                    <div>
                        <div class="font-bold">Danil Shutsky</div>
                        <div class="text-xs font-normal">15.11.2023 в 13:57</div>
                        <div class="text-sm mt-2 break-words">Comment text</div>
                    </div>
                </div>

                <div class="flex items-center space-x-4 grow my-4">
                    <img src="https://ui-avatars.com/api/?name=DS"
                         class="rounded-full w-12 h-12 align-middle border-none m-0"
                         alt="DS"
                    >
                    <div>
                        <div class="font-bold">Danil Shutsky</div>
                        <div class="text-xs font-normal">15.11.2023 в 13:57</div>
                        <div class="text-sm mt-2 break-words">Comment text</div>
                        <div class="text-sm mt-2">
                            <x-moonshine::link-button href="">Ответить</x-moonshine::link-button>
                        </div>
                    </div>
                </div>

                <x-moonshine::divider />

                <div class="flex items-center space-x-4 grow my-4" style="margin-left: 60px">
                    <img src="https://ui-avatars.com/api/?name=DS"
                         class="rounded-full w-12 h-12 align-middle border-none m-0"
                         alt="DS"
                    >
                    <div>
                        <div class="font-bold">Danil Shutsky</div>
                        <div class="text-xs font-normal">15.11.2023 в 13:57</div>
                        <div class="text-sm mt-2 break-words">Comment text</div>
                    </div>
                </div>
            </div>
        </x-moonshine::column>
    </x-moonshine::grid>
@endsection
