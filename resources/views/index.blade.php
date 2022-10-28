@extends('layouts.auth')

@section('content')
    @auth
        <form method="POST" action="{{route('logout')}}">
            @csrf
            @method('DELETE')
            <x-forms.primary-button>Выйти</x-forms.primary-button>
        </form>
    @endauth

@endsection
