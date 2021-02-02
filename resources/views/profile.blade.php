@extends('orders/index')

@section('options')
    <h4>Список замовлень користувача {{ auth()->user()->name }}:</h4>
    <h5>{{ auth()->user()->email }}</h5>

    <div class="orders">
        <table class="table table-light">
            <thead>
                <th>Дата замовлення</th>
                <th>Номер телефону</th>
                <th>Місто</th>
                <th>Адреса</th>
                <th>Книги</th>
                <th>Статус</th>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
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
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
