@extends('layout')

@section('title')
    Редагувати жанр
@endsection

@section('content')
    <h4>Редагування жанру:</h4>
    <form method="post" action="/genres/{{ $genre->id }}">
        @csrf
        {{ method_field('patch') }}

        <!---Назва--->
        @include("includes/input", ['object' => $genre, 'id' => 'name', 'label' => 'Введіть назву жанру:', 'name' => 'Назва жанру'])
        <!--Опис-->
        @include("includes/text", ['object' => $genre, 'id' => 'description', 'label' => 'Введіть опис жанру:', 'name' => 'Опис жанру'])

        <!--Кнопки-->
        <div class="button-block row">
            @can('delete', \App\Models\Genre::class)
                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal">Видалити</button>
            @endcan
            @can('update', \App\Models\Genre::class)
                <button type="submit" class="btn btn-primary">Зберегти</button>
            @endcan
        </div>
    </form>

    <!--Видалити-->
    @can('delete', \App\Models\Genre::class)
        @include("includes/delete", ['label' => 'Підтвердіть видалення жанру', 'object' => $genre, 'id' => 'delete-genre', 'route' => '/genres'])
    @endcan
@endsection
