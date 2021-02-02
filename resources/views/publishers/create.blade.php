@extends('layout')

@section('title')
    Створити видавництво
@endsection

@section('content')
    <!--Заголовок-->
    <h4>Додавання нового видавництва:</h4>
    <!--Форма-->
    <form method="post" action="/publishers" enctype="multipart/form-data">
        @csrf

        <!--Назва-->
        @include("includes/input", ['id' => 'name', 'label' => 'Введіть назву видавництва:', 'name' => 'Назва видавництва'])
        <!--Рік-->
        @include("includes/input", ['id' => 'year', 'label' => 'Введіть рік заснування:', 'name' => 'Рік заснування'])
        <!--Країна-->
        @include("includes/input", ['id' => 'country', 'label' => 'Введіть країну:', 'name' => 'Країна'])
        <!--Лого-->
        @include("includes/file", ['id' => 'logo', 'label' => 'Оберіть логотип видавництва:', 'text' => 'Завантажити логотип', 'file' => 'Логотип не обрано!'])
        <!--Опис-->
        @include("includes/text", ['id' => 'description', 'label' => 'Введіть опис видавництва:', 'name' => 'Опис видавництва'])

        <!--Кнопка-->
        <div class="button-block row">
            @can('create', \App\Models\Publisher::class)
                <button type="submit" class="save btn btn-primary">Зберегти</button>
            @endcan
        </div>
    </form>
@endsection
