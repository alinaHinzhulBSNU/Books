@extends('layout')

@section('title')
    Додати користувача
@endsection

@section('content')
    <h4>Надати права користувачам:</h4>
    <form method="post" action="/admin/users">
    @csrf

    <!--Користувачі-->
    @include("includes/select", ['collection' => $users, 'id' => 'user_id', 'label' => 'Оберіть користувача:', 'placeholder' => 'Користувач'])
    <!--Право-->
    <div class="form-group">
        <div class="row">
            <div class="label col-md-4">
                <label for="right">Оберіть право:</label>
            </div>
            <div class="col-md-8">
                <select id="right" name="right" class="form-control {{ $errors->has("right") ? 'invalid':'' }}">
                    <option selected disabled value="0">Право</option>
                    <option value="create">Create</option>
                    <option value="read">Read</option>
                    <option value="update">Update</option>
                    <option value="delete">Delete</option>
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
                    <option value="book">Book</option>
                    <option value="author">Author</option>
                    <option value="genre">Genre</option>
                    <option value="publisher">Publisher</option>
                    <option value="comment">Comment</option>
                </select>
            </div>
            @include("includes/validationErrors", ['errFieldName' => "model"])
        </div>
    </div>

    <!--Кнопка-->
        <div class="button-block row">
            <button type="submit" class="save btn btn-primary">Зберегти</button>
        </div>
    </form>
@endsection
