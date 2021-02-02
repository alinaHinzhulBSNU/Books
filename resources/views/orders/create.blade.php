@extends('layout')

@section('title')
    Відправити замовлення
@endsection

@section('content')
    <h4>Створення нового замовлення:</h4>
    <form method="post" action="/profile/orders">
        @csrf

        <!--Користувач-->
        <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
        <!--Місто-->
        @include("includes/input", ['id' => 'phone_number', 'label' => 'Введіть номер телефону:', 'name' => 'Номер телефону лише з цифр!'])
        <!--Місто-->
        @include("includes/input", ['id' => 'city', 'label' => 'Введіть назву міста:', 'name' => 'Місто'])
        <!--Адреса-->
        @include("includes/input", ['id' => 'address', 'label' => 'Введіть адресу:', 'name' => 'Адреса'])

        <!--Кнопка-->
        <div class="button-block row">
            @can('surf')
                <button type="submit" class="save btn btn-primary">Зберегти</button>
            @endcan
        </div>
    </form>
@endsection
