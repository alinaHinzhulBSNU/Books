@extends('layout')

@section('title')
    Редагування прав
@endsection

@section('content')
<h4>Редагувати права користувача:</h4>
<form method="post" action="/admin/users/{{ $userRight->id }}">
    @csrf
    {{ method_field('patch') }}

    <!--Користувачі-->
    <div class="form-group">
        <div class="row">
            <div class="label col-md-4">
                <label for="author">Оберіть користувача</label>
            </div>
            <div class="col-md-8">
                <select id="user_id" name="user_id" class="form-control {{ $errors->has("user_id") ? 'invalid':'' }}">
                    <option selected disabled value="0">Користувач</option>
                    @foreach($users as $currentUser)
                        <option @if($currentUser->id == $user->id) selected @endif
                        value="{{ $currentUser->id }}">{{ $currentUser->name }}</option>
                    @endforeach
                </select>
            </div>
            @include("includes/validationErrors", ['errFieldName' => "user_id"])
        </div>
    </div>
    <!--Право-->
        <div class="form-group">
            <div class="row">
                <div class="label col-md-4">
                    <label for="right">Оберіть право:</label>
                </div>
                <div class="col-md-8">
                    <select id="right" name="right" class="form-control {{ $errors->has("right") ? 'invalid':'' }}">
                        <option selected disabled value="0">Право</option>
                        <option value="create" @if($userRight->right == "create") selected @endif>Create</option>
                        <option value="read" @if($userRight->right == "read") selected @endif>Read</option>
                        <option value="update" @if($userRight->right == "update") selected @endif>Update</option>
                        <option value="delete"@if($userRight->right == "delete") selected @endif>Delete</option>
                    </select>
                </div>
                @include("includes/validationErrors", ['errFieldName' => "right"])
            </div>
        </div>
        <!--Модель-->
        <div class="form-group">
            <div class="row">
                <div class="label col-md-4">
                    <label for="model">Оберіть модель:</label>
                </div>
                <div class="col-md-8">
                    <select id="model" name="model" class="form-control {{ $errors->has("model") ? 'invalid':'' }}">
                        <option selected disabled value="0">Модель</option>
                        <option value="book" @if($userRight->model == "book") selected @endif>Book</option>
                        <option value="author" @if($userRight->model == "author") selected @endif>Author</option>
                        <option value="genre" @if($userRight->model == "genre") selected @endif>Genre</option>
                        <option value="publisher" @if($userRight->model == "publisher") selected @endif>Publisher</option>
                        <option value="comment" @if($userRight->model == "comment") selected @endif>Comment</option>
                    </select>
                </div>
                @include("includes/validationErrors", ['errFieldName' => "model"])
            </div>
        </div>

        <!--Кнопки-->
        <div class="button-block row">
            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal">Видалити</button>
            <button type="submit" class="btn btn-primary">Зберегти</button>
        </div>
    </form>

    <!--Видалити-->
    @include("includes/delete", ['label' => 'Підтвердіть видалення права', 'object' => $userRight, 'id' => 'delete-user', 'route' => '/admin/users'])
@endsection
