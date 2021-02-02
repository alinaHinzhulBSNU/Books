@extends('layout')

@section('title')
    Редагувати автора
@endsection

@section('content')
    <!--Заголовок-->
    <h4>Додавання нового автора:</h4>
    <!--Форма-->
    <form method="post" action="/authors/{{ $author->id }}" enctype="multipart/form-data">
        @csrf
        {{ method_field('patch') }}

        <!--Ім'я-->
        @include("includes/input", ['object' => $author, 'id' => 'name', 'label' => 'Введіть ПІБ автора:', 'name' => 'Ім`я автора'])
        <!--Фотографія-->
        @include("includes/file", ['id' => 'photo', 'label' => 'Оберіть НОВУ фотографію автора:', 'text' => 'Завантажити фото', 'file' => 'Файл не обрано!'])
        <!--Біографія-->
        @include("includes/text", ['object' => $author, 'id' => 'biography', 'label' => 'Введіть біографію автора:', 'name' => 'Біографія автора'])

        <!--Кнопки-->
        <div class="button-block row">
            @can('delete', \App\Models\Author::class)
                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal">Видалити</button>
            @endcan
            @can('update', \App\Models\Author::class)
                <button type="submit" class="btn btn-primary">Зберегти</button>
            @endcan
        </div>
    </form>

    <!--Видалити-->
    @can('delete', \App\Models\Author::class)
        @include("includes/delete", ['label' => 'Підтвердіть видалення автора', 'object' => $author, 'id' => 'delete-author', 'route' => '/authors'])
    @endcan
@endsection
