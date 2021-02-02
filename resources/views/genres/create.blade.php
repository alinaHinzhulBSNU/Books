@extends('layout')

@section('title')
    Створити жанр
@endsection

@section('content')
    <!--Заголовок-->
    <h4>Додавання нового жанру:</h4>
    <!--Форма-->
    <form method="post" action="/genres">
        @csrf

        <!--Назва-->
        @include("includes/input", ['id' => 'name', 'label' => 'Введіть назву жанру:', 'name' => 'Назва жанру'])
        <!--Опис-->
        @include("includes/text", ['id' => 'description', 'label' => 'Введіть опис жанру:', 'name' => 'Опис жанру'])

        <!--Кнопка-->
        @can('create', \App\Models\Genre::class)
            <div class="button-block row">
                <button type="submit" class="save btn btn-primary">Зберегти</button>
            </div>
        @endcan
    </form>
@endsection
