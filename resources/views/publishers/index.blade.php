@extends('layout')

@section('title')
    Видавництва
@endsection

@section('content')
    <h4>Список видавництв:</h4>

    <!--Додати нове видавництво-->
    @can('create', \App\Models\Publisher::class)
        <a href="/publishers/create">
            <button class="add btn btn-primary">Додати видавництво</button>
        </a>
    @endcan

    <!--Список авторів-->
    <div class="row row-flex">
    @foreach($publishers as $publisher)
        <div class="info-block-wrapper col-md-6">
            <div class="info-block">
                <!--Заголовок-->
                <div class="row">
                    <!--Логотип-->
                    <div class="logo">
                        <img src="{{ asset('/storage/'.$publisher->logo) }}">
                    </div>
                    <!--Назва-->
                    <div class="name">
                        <h5>{{ $publisher->name }}</h5>
                    </div>
                </div>

                <!--Текст-->
                <div class="description">
                    <p class="details">Країна: {{ $publisher->country }}. Рік заснування: {{ $publisher->year }}</p>
                    <p>{{ $publisher->description }}</p>
                </div>

                <!--Кнопки-->
                <div class="options">
                    @can('update', \App\Models\Publisher::class)
                        <a href="/publishers/{{ $publisher->id }}/edit">
                            <button class="btn btn-primary">Редагувати</button>
                        </a>
                    @endcan
                    @if(auth()->user()->can('read', \App\Models\Book::class) || auth()->user()->can('surf'))
                        <a href="/publishers/{{ $publisher->id }}/books">
                            <button class="btn btn-primary">Книги</button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    </div>
@endsection
