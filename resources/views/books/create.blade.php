@extends('layout')

@section('title')
    Нова книга
@endsection

@section('content')
    <h4>Створення нової книги:</h4>
    <form method="post" action="/books" enctype="multipart/form-data">
        @csrf

        <!--Назва-->
        @include("includes/input", ['id' => 'name', 'label' => 'Введіть назву книги:', 'name' => 'Назва книги'])
        <!--Лого-->
        @include("includes/file", ['id' => 'cover', 'label' => 'Оберіть обкладинку книги:', 'text' => 'Завантажити обкладинку', 'file' => 'Обкладинка не обрана!'])
        <!--Автор-->
        @include("includes/select", ['collection' => $authors, 'id' => 'author_id', 'label' => 'Оберіть автора книги:', 'placeholder' => 'Автор книги'])
        <!--Жанр-->
        @include("includes/select", ['collection' => $genres, 'id' => 'genre_id', 'label' => 'Оберіть жанр книги:', 'placeholder' => 'Жанр книги'])
        <!--Видавництво-->
        @include("includes/select", ['collection' => $publishers, 'id' => 'publisher_id', 'label' => 'Оберіть видавництво:', 'placeholder' => 'Видавництво'])
        <!--Кількість-->
        @include("includes/input", ['id' => 'quantity', 'label' => 'Введіть кількість:', 'name' => 'Кількість даних книг на складі'])
        <!--Мова-->
        @include("includes/input", ['id' => 'language', 'label' => 'Введіть мову:', 'name' => 'Мова'])
        <!--Ціна-->
        @include("includes/input", ['id' => 'price', 'label' => 'Введіть ціну(грн):', 'name' => 'Ціна(грн)'])
        <!--Рік-->
        @include("includes/input", ['id' => 'year', 'label' => 'Введіть рік:', 'name' => 'Рік'])
        <!--Опис-->
        @include("includes/text", ['id' => 'description', 'label' => 'Введіть опис книги:', 'name' => 'Опис книги'])

        <!--Кнопка-->
        <div class="button-block row">
            @can('create', \App\Models\Book::class)
                <button type="submit" class="save btn btn-primary">Зберегти</button>
            @endcan
        </div>
    </form>
@endsection
