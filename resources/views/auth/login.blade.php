@extends('layouts.login')

@section('content')
    <div class="authentication">
        <div class="authentication-logo">
            <a href="/" rel="home">
                <img class="h-16"
                     src="{{ config('moonshine.logo') ?: asset('vendor/moonshine/logo.svg') }}"
                     alt="{{ config('moonshine.title') }}"
                >
            </a>
        </div>

        <div class="authentication-content">
            {{ $form->render() }}
        </div>

        <x-moonshine::link-native :href="route('register')">Регистрация</x-moonshine::link-native>
    </div>
@endsection
