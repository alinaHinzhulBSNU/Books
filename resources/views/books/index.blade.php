@extends('layout')

@section('title')
    Книги
@endsection

@section('content')
    <h4>Список книг:</h4>

    <!--Фільтрація-->
    @if(auth()->user()->can('read', \App\Models\Book::class) || auth()->user()->can('surf'))
    <div class="filter-menu">
        <div class="row">
            <!--Автор-->
            <div class="col-md-2">
                @include("includes/filter", ['collection' => $authors, 'id' => 'author_id', 'placeholder' => 'Автор книги', 'route' => '/authors'])
            </div>

            <!--Жанр-->
            <div class="col-md-2">
                @include("includes/filter", ['collection' => $genres, 'id' => 'genre_id', 'placeholder' => 'Жанр книги', 'route' => '/genres'])
            </div>

            <!--Видавництво-->
            <div class="col-md-2">
                @include("includes/filter", ['collection' => $publishers, 'id' => 'publisher_id', 'placeholder' => 'Видавництво', 'route' => '/publishers'])
            </div>

            <!--Скасувати фільтри-->
            <div class="col-md-2">
                <a href="/books">
                    <button class="btn btn-primary">Скасувати фільтри</button>
                </a>
            </div>

            <!--Назва-->
            <div class="col-md-4">
                <form method="get" action="/search">
                    <div class="row">
                        <div class="col-md-10">
                            <input type="text" name="name" id="name" placeholder="Назва книги" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!--Додати нову книгу-->
    @can('create', \App\Models\Book::class)
        <a href="/books/create">
            <button class="add btn btn-primary">Додати книгу</button>
        </a>
    @endcan

    <!--Список книг-->
    <div class="row row-flex">
    @foreach($books as $book)
        <div class="book-container col-md-3">
            <div class="book">
                <div class="cover">
                    <img src="{{ asset('/storage/'.$book->cover) }}"/>
                </div>
                <div class="title">
                    <h5>{{ $book->name }}</h5>
                </div>
                <div class="details">
                    <p>{{ $book->author->name }}</p>
                    <p class="price">
                        Ціна: <b>{{ $book->price }} ₴</b>
                    </p>
                </div>
                <div class="options">
                    @if(auth()->user()->can('read', \App\Models\Book::class) || auth()->user()->can('surf'))
                        <a href="/books/{{ $book->id }}">
                            <button class="btn btn-primary">Детальніше</button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    </div>
@endsection
