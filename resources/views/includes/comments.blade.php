<div class="book-name row">
    <h4>Коментарі:</h4>
</div>

@foreach($comments as $comment)
    <div class="info-block comment">
        <div class="row">
            <div class="comment-info col-md-3">
                <p>
                    <b>{{ $comment->user->name }}</b>
                </p>
                <p>
                    {{ $comment->created_at->format('d/m/Y') }}
                </p>
            </div>
            <div class="comment-text col-md-9">
                {{ $comment->text }}
            </div>
        </div>
        @can('update', $comment, \App\Models\Comment::class)
            <div class="comment-buttons-cover row">
                <div class="comment-buttons">
                    <a href="/comments/{{ $comment->id }}/edit">
                        <button class="btn btn-primary">Редагувати</button>
                    </a>
                </div>
            </div>
        @endcan
    </div>
@endforeach
