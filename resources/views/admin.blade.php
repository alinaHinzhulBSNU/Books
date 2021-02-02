@extends('layout')

@section('title')
    Адміністрування
@endsection

@section('content')
    <div class="admin row">
        <div class="col-md-6">
            <a href="/admin/orders">
                <button class="btn btn-primary">Всі замовлення</button>
            </a>
        </div>
        <div class="col-md-6">
            <a href="/admin/users">
                <button class="btn btn-primary">Всі користувачі</button>
            </a>
        </div>
    </div>
    @yield('option')
@endsection
