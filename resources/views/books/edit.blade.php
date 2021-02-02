@extends('layout')

@section('title')
    Редагувати книгу
@endsection

@section('content')
    <h4>Редагування книги:</h4>

    <form method="post" action="/books/{{ $book->id }}" enctype="multipart/form-data">
        @csrf
        {{ method_field('patch') }}

        <!--Назва-->
        @include("includes/input", ['object' => $book, 'id' => 'name', 'label' => 'Введіть назву книги:', 'name' => 'Назва книги'])
        <!--Лого-->
        @include("includes/file", ['id' => 'cover', 'label' => 'Оберіть НОВУ обкладинку книги:', 'text' => 'Завантажити обкладинку', 'file' => 'Обкладинка не обрана!'])
        <!--Автор-->
        @include("includes/select", ['object' => $book, 'collection' => $authors, 'id' => 'author_id', 'label' => 'Оберіть автора книги:', 'placeholder' => 'Автор книги'])
        <!--Жанр-->
        @include("includes/select", ['object' => $book, 'collection' => $genres, 'id' => 'genre_id', 'label' => 'Оберіть жанр книги:', 'placeholder' => 'Жанр книги'])
        <!--Видавництво-->
        @include("includes/select", ['object' => $book, 'collection' => $publishers, 'id' => 'publisher_id', 'label' => 'Оберіть видавництво:', 'placeholder' => 'Видавництво'])
        <!--Кількість-->
        @include("includes/input", ['object' => $book, 'id' => 'quantity', 'label' => 'Введіть кількість:', 'name' => 'Кількість даних книг на складі'])
        <!--Мова-->
        @include("includes/input", ['object' => $book, 'id' => 'language', 'label' => 'Введіть мову:', 'name' => 'Мова'])
        <!--Ціна-->
        @include("includes/input", ['object' => $book, 'id' => 'price', 'label' => 'Введіть ціну(грн):', 'name' => 'Ціна(грн)'])
        <!--Рік-->
        @include("includes/input", ['object' => $book, 'id' => 'year', 'label' => 'Введіть рік:', 'name' => 'Рік'])
        <!--Опис-->
        @include("includes/text", ['object' => $book, 'id' => 'description', 'label' => 'Введіть опис книги:', 'name' => 'Опис книги'])

        <!--Кнопки-->
        <div class="button-block row">
            @can('delete', \App\Models\Book::class)
                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal">Видалити</button>
            @endcan
            @can('update', \App\Models\Book::class)
                <button type="submit" class="btn btn-primary">Зберегти</button>
            @endcan
        </div>
    </form>

    <!--Видалити-->
    @can('delete', \App\Models\Book::class)
        @include("includes/delete", ['label' => 'Підтвердіть видалення книги', 'object' => $book, 'id' => 'delete-book', 'route' => '/books'])
    @endcan
@endsection
