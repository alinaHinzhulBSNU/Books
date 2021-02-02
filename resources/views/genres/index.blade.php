@extends('layout')

@section('title')
    Жанри
@endsection

@section('content')
    <h4>Список жанрів:</h4>

    <!--Додати новий жанр-->
    @can('create', \App\Models\Genre::class)
        <a href="/genres/create">
            <button class="add btn btn-primary">Додати жанр</button>
        </a>
    @endcan

    <!--Список жанрів-->
    <div class="row row-flex">
    @foreach($genres as $genre)
        <div class="info-block-wrapper col-md-6">
            <div class="info-block">
                <!--Назва-->
                <div class="title">
                    <h5>{{ $genre->name }}</h5>
                </div>

                <!--Опис-->
                <div class="description">
                    {{ $genre->description }}
                </div>

                <!--Кнопки-->
                <div class="options">
                    @can('update', \App\Models\Genre::class)
                        <a href="/genres/{{ $genre->id }}/edit">
                            <button class="btn btn-primary">Редагувати</button>
                        </a>
                    @endcan
                    @if(auth()->user()->can('read', \App\Models\Book::class) || auth()->user()->can('surf'))
                        <a href="/genres/{{ $genre->id }}/books">
                            <button class="btn btn-primary">Книги</button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    </div>
@endsection
