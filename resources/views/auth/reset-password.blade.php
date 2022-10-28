@extends('layouts.auth')
@section('title','Восстановление пароля')

@section('content')
    <x-forms.auth-forms title="Восстановление пароля" action="" method="POST">
        @csrf
        <x-forms.text-input
            type="hidden"
            name="token"
            value="{{request('token')}}"
        ></x-forms.text-input>
        <x-forms.text-input
            type="email"
            placeholder="E-mail"
            required
            name="email"
            :_is_error="$errors->has('email')"
            value="{{ request('email') }}"

        ></x-forms.text-input>
        @error('email')
        <x-forms.error>
            {{$message}}
        </x-forms.error>
        @enderror

        <x-forms.text-input
            type="password"
            placeholder="Пароль"
            required
            name="password"
            :_is_error="$errors->has('password')"
        ></x-forms.text-input>
        @error('password')
        <x-forms.error>
            {{$message}}
        </x-forms.error>
        @enderror

        <x-forms.text-input
            type="password"
            placeholder="Пароль"
            required
            name="password_confirmation"
            :_is_error="$errors->has('password_confirmation')"
        ></x-forms.text-input>
        @error('password_confirmation')
        <x-forms.error>
            {{$message}}
        </x-forms.error>
        @enderror
        <x-slot:buttons></x-slot:buttons>
        <x-slot:socialAuth></x-slot:socialAuth>
        <x-forms.primary-button>Обновить</x-forms.primary-button>


    </x-forms.auth-forms>
@endsection
