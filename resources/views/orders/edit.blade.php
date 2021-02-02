@extends('layout')

@section('title')
    Змінити замовлення
@endsection

@section('content')
    <h4>Редагування замовлення:</h4>

    <form method="post" action="/admin/orders/{{ $order->id }}">
        @csrf
        {{ method_field('patch') }}

        <!--Статус-->
        <div class="form-group">
            <div class="row">
                <div class="label col-md-4">
                    <label for="author">Змініть статус замовлення</label>
                </div>
                <div class="col-md-8">
                    <select id="status" name="status" class="form-control">
                        <option @if($order->status === "new") selected @endif value="new">New</option>
                        <option @if($order->status === "processed") selected @endif value="processed">Processed</option>
                        <option @if($order->status === "packed") selected @endif value="packed">Packed</option>
                        <option @if($order->status === "shipped") selected @endif value="shipped">Shipped</option>
                        <option @if($order->status === "delivered") selected @endif value="delivered">Delivered</option>
                    </select>
                </div>
            </div>
        </div>

        <!--Кнопки-->
        <div class="button-block row">
            @if(auth()->user()->can('admin') || auth()->user()->can('manage'))
                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal">Видалити</button>
            @endif
            @if(auth()->user()->can('admin') || auth()->user()->can('manage'))
                <button type="submit" class="btn btn-primary">Зберегти</button>
            @endif
        </div>
    </form>

    <!--Видалити-->
    @can('admin')
        @include("includes/delete", ['label' => 'Підтвердіть видалення замовлення', 'object' => $order, 'id' => 'delete-order', 'route' => '/admin/orders'])
    @endcan
@endsection
