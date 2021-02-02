@extends('layout')

@section('title')
    Редагувати видавництво
@endsection

@section('content')
    <!--Заголовок-->
    <h4>Редагування видавництва:</h4>
    <!--Форма-->
    <form method="post" action="/publishers/{{ $publisher->id }}" enctype="multipart/form-data">
        @csrf
        {{ method_field('patch') }}

        <!--Назва-->
        @include("includes/input", ['object' => $publisher, 'id' => 'name', 'label' => 'Введіть назву видавництва:', 'name' => 'Назва видавництва'])
        <!--Рік-->
        @include("includes/input", ['object' => $publisher, 'id' => 'year', 'label' => 'Введіть рік заснування:', 'name' => 'Рік заснування'])
        <!--Країна-->
        @include("includes/input", ['object' => $publisher, 'id' => 'country', 'label' => 'Введіть країну:', 'name' => 'Країна'])
        <!--Лого-->
        @include("includes/file", ['id' => 'logo', 'label' => 'Оберіть логотип видавництва:', 'text' => 'Завантажити логотип', 'file' => 'Логотип не обрано!'])
        <!--Опис-->
        @include("includes/text", ['object' => $publisher, 'id' => 'description', 'label' => 'Введіть опис видавництва:', 'name' => 'Опис видавництва'])

        <!--Кнопки-->
        <div class="button-block row">
            @can('delete', \App\Models\Publisher::class)
                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal">Видалити</button>
            @endcan
            @can('update', \App\Models\Publisher::class)
                <button type="submit" class="btn btn-primary">Зберегти</button>
            @endcan
        </div>
    </form>

    <!--Видалити-->
    @can('delete', \App\Models\Publisher::class)
        @include("includes/delete", ['label' => 'Підтвердіть видалення видавництва', 'object' => $publisher, 'id' => 'delete-publisher', 'route' => '/publishers'])
    @endcan
@endsection
