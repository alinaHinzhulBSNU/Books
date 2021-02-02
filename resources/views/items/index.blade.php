@extends('cart')

@section('items')
    <div class="items">
        <table class="table table-light">
            <thead>
                <th>Назва книги</th>
                <th>Кількість книг</th>
                <th>Вартість</th>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->book->author->name }} "{{ $item->book->name }}"</td>
                        <td>
                            <div class="row">
                                @can('surf')
                                    <div class="col-md-4">
                                        <form method="post" action="/cart/items/{{ $item->id }}">
                                            @csrf
                                            {{ method_field('patch') }}
                                            <input type="hidden" id="operation" name="operation" value="+">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endcan
                                <div class="col-md-4">
                                    {{ $item->quantity }} шт.
                                </div>
                                @can('surf')
                                    <div class="col-md-4">
                                        <form method="post" action="/cart/items/{{ $item->id }}">
                                            @csrf
                                            {{ method_field('patch') }}
                                            <input type="hidden" id="operation" name="operation"  value="-">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endcan
                            </div>
                        </td>
                        <td>{{ $item->quantity }} x {{ $item->book->price }}₴</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <h3>Загальна вартість: <b>{{ $total }}₴</b></h3>
        </div>
        <div class="row">
            @if(auth()->user()->can('surf') && count($items) > 0)
                <a href="/profile/orders/create">
                    <button type="button" class="add btn btn-primary">Оформити замовлення</button>
                </a>
            @endif
        </div>
    </div>
@endsection
