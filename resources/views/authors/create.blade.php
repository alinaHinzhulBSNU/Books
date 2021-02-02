@extends('layout')

@section('title')
    Додати автора
@endsection

@section('content')
    <!--Заголовок-->
    <h4>Додавання нового автора:</h4>
    <!--Форма-->
    <form method="post" action="/authors" enctype="multipart/form-data">
        @csrf

        <!--Ім'я-->
        @include("includes/input", ['id' => 'name', 'label' => 'Введіть ПІБ автора:', 'name' => 'Ім`я автора'])
        <!--Фотографія-->
        @include("includes/file", ['id' => 'photo', 'label' => 'Оберіть фотографію автора:', 'text' => 'Завантажити фото', 'file' => 'Файл не обрано!'])
        <!--Біографія-->
        @include("includes/text", ['id' => 'biography', 'label' => 'Введіть біографію автора:', 'name' => 'Біографія автора'])

        <!--Кнопка-->
        <div class="button-block row">
            @can('create', \App\Models\Author::class)
                <button type="submit" class="save btn btn-primary">Зберегти</button>
            @endcan
        </div>
    </form>
@endsection
