@extends('layout')

@section('title')
    Редагувати коментар
@endsection

@section('content')
    <h4>Редагування коментаря</h4>

    <form method="post" action="/comments/{{ $comment->id }}">
        @csrf
        {{ method_field('patch') }}

        <!--Книга-->
        <input type="hidden" id="book_id" name="book_id" value="{{ $comment->book_id }}">
        <!--Користувач-->
        <input type="hidden" id="user_id" name="user_id" value="{{ $comment->user_id }}">
        <!--Опис-->
        @include("includes/text", ['object' => $comment, 'id' => 'text', 'label' => 'Відредагуйте коментар:', 'name' => 'Коментар'])

        <!--Кнопки-->
            <div class="button-block row">
                @can('delete', $comment, \App\Models\Comment::class)
                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal">Видалити</button>
                @endcan
                @can('update', $comment, \App\Models\Comment::class)
                    <button type="submit" class="btn btn-primary">Зберегти</button>
                @endcan
            </div>
    </form>

    @can('delete', $comment, \App\Models\Comment::class)
        <!--Modal-->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">
                            <p>Підтвердіть видалення коментаря</p>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        Видалити коментар?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Ні</button>
                        <button type="button" class="btn btn-danger" id="delete-comment">Видалити</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function(){
                $("{{ "#delete-comment" }}").click(function(){
                    var id = {!! $comment->id !!};
                    $.ajax({
                        url: '/comments/' + id,
                        type: 'post',
                        data: {
                            _method: 'delete',
                            _token: "{!! csrf_token() !!}"
                        },
                        success:function(msg){
                            location.href="/books/{{ $comment->book_id }}";
                        }
                    });
                });
            });
        </script>
    @endcan
@endsection
