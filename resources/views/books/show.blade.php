@extends('layout')

@section('title')
    Книга
@endsection

@section('content')
    <!--Назва-->
    <div class="book-name row">
        <h4 class="book-name">
            {{ $book->name }}<i class="fas fa-book-open"></i>{{ $book->author->name }}
        </h4>
    </div>

    <!--Опис-->
    <div class="show-book row">
        <!--Обкладинка-->
        <div class="col-md-5">
            <img src="{{ asset('/storage/'.$book->cover) }}">
        </div>

        <!--Детальна інформація-->
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-4">
                    <p>Автор:</p>
                    <p>Жанр:</p>
                    <p>Видавництво:</p>
                    <p>Мова:</p>
                    <p>Рік видання:</p>
                    <p>Ціна:</p>
                </div>
                <div class="description-items col-md-8">
                    <a href="/authors/{{ $book->author->id }}/books">
                        <p>{{ $book->author->name}}</p>
                    </a>
                    <a href="/genres/{{ $book->genre->id }}/books">
                        <p>{{ $book->genre->name }}</p>
                    </a>
                    <a href="/publishers/{{ $book->publisher->id }}/books">
                        <p>{{ $book->publisher->name }}</p>
                    </a>
                    <p>{{ $book->language }}</p>
                    <p>{{ $book->year }}</p>
                    <p>{{ $book->price }} ₴</p>
                </div>
            </div>
            <h5>Опис</h5>
            <div class="description row">
                <p>{{ $book->description }}</p>
            </div>
        </div>

        <!--Кнопки-->
        <div class="buttons col-md-2">
            <!--Чи є в наявності-->
            @if($book->quantity > 0)
                <p class="success">Є в наявності!</p>
            @else
                <p class="failed">Немає в наявності!</p>
            @endif

            <!--Ціна-->
            <p><span style="font-size: 24px;">{{ $book->price }}</span> ₴</p>

            <!--Додати у кошик-->
            @can('surf')
                <a href="#">
                    <form method="post" action="/cart/items">
                        @csrf

                        <input type="hidden" id="book_id" name="book_id" value="{{ $book->id }}">
                        <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" id="quantity" name="quantity" value="1">
                        <button type="submit" @if($book->quantity < 1) disabled @endif class="btn btn-primary">Додати в кошик</button>
                    </form>
                </a>
            @endcan
            @can('update', \App\Models\Book::class)
                <!--Редагувати книгу-->
                <a href="/books/{{ $book->id }}/edit">
                    <button class="btn btn-primary">Редагувати</button>
                </a>
            @endcan
        </div>
    </div>

    <!--Написати коментар-->
    @if(auth()->user()->can('create', \App\Models\Comment::class) || auth()->user()->can('surf'))
        <div class="book-name row">
            <h4>Ваш коментар до книги {{ $book->name }}:</h4>
        </div>

    <form method="post" action="/comments">
        @csrf

        <!--Книга-->
        <input type="hidden" id="book_id" name="book_id" value="{{ $book->id }}">
        <!--Користувач-->
        <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
        <!--Опис-->
        @include("includes/text", ['id' => 'text', 'label' => 'Введіть текст коментаря:', 'name' => 'Коментар'])

        <button type="submit" class="btn btn-primary">Зберегти</button>
    </form>
    @endif

    <!--Коментарі-->
    @if(auth()->user()->can('read', \App\Models\Comment::class) || auth()->user()->can('surf'))
        @include("includes/comments", ['comments' => $book->comments])
    @endif
@endsection
