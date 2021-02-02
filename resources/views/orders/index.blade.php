@extends('layout')

@section('title')
    Профіль
@endsection

@section('content')
    @yield('options')

    @can('admin')
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
    @endcan

    @if(auth()->user()->can('admin') || auth()->user()->can('manage'))
    <h4>Список всіх замовлень:</h4>

    <div class="orders">
        <table class="table table-light">
            <thead>
                <td>Користувач</td>
                <th>Дата замовлення</th>
                <th>Номер телефону</th>
                <th>Місто</th>
                <th>Адреса</th>
                <th>Книги</th>
                <th>Статус</th>
                <th></th>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>{{ $order->phone_number }}</td>
                    <td>{{ $order->city }}</td>
                    <td>{{ $order->address }}</td>
                    <td>
                        @foreach($order->items as $item)
                            <p>{{ $item->book->author->name }} "{{ $item->book->name }}" {{ $item->quantity }}шт. x {{ $item->book->price }}₴</p>
                        @endforeach
                    </td>
                    <td>{{ $order->status }}</td>
                    <td>
                        <a href="/admin/orders/{{ $order->id }}/edit">
                            <button type="button" class="btn btn-primary">Редагувати</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
@endsection
