@extends('layout')

@section('title')
    Автори
@endsection

@section('content')
    <h4>Список авторів:</h4>

    <!--Додати нового автора-->
    @can('create', \App\Models\Author::class)
        <a href="/authors/create">
            <button class="add btn btn-primary">Додати автора</button>
        </a>
    @endcan

    <!--Список авторів-->
    <div class="row row-flex">
    @foreach($authors as $author)
        <div class="info-block-wrapper col-md-6">
            <div class="info-block">
                <!--Заголовок-->
                <div class="row">
                    <!--Фотографія-->
                    <div class="photo col-md-2">
                        <img src="{{ asset('/storage/'.$author->photo) }}">
                    </div>
                    <!--Назва-->
                    <div class="name">
                        <h5>{{ $author->name }}</h5>
                    </div>
                </div>

                <!--Текст-->
                <div class="description">
                    <p>{{ $author->biography }}</p>
                </div>

                <!--Кнопки-->
                <div class="options">
                    @can('update', \App\Models\Author::class)
                        <a href="/authors/{{ $author->id }}/edit">
                            <button class="btn btn-primary">Редагувати</button>
                        </a>
                    @endcan
                    @if(auth()->user()->can('read', \App\Models\Book::class) || auth()->user()->can('surf'))
                        <a href="/authors/{{ $author->id }}/books">
                            <button class="btn btn-primary">Книги</button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    </div>
@endsection
