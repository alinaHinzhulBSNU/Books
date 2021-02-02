@extends('admin')

@section('title')
    Права користувачів
@endsection

@section('option')
    <h4>Адміністрування прав доступу користувачів:</h4>

    <!--Додати нове право-->
    <a href="/admin/users/create">
        <button class="add btn btn-primary">Додати право</button>
    </a>
    <div class="rights">
        <table class="table table-light">
            <thead>
                <th>Користувач</th>
                <th>Модель</th>
                <th>Право</th>
                <th>Редагувати</th>
            </thead>
            <tbody>
                @foreach($userRights as $userRight)
                    <tr>
                        <td>{{ $userRight->user->name }}</td>
                        <td>{{ $userRight->model }}</td>
                        <td>{{ $userRight->right }}</td>
                        <td>
                            <a href="/admin/users/{{ $userRight->id }}/edit">
                                <button class="btn btn-primary">Редагувати</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
