@extends('layout')

@section('title')
    Корзина
@endsection

@section('content')
    <h4>Товари в корзині:</h4>
    @yield('items')
@endsection
