<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        if((Auth::user() && Auth::user()->can('read', Comment::class)) || Auth::user() && Auth::user()->can('surf')) {
            return redirect()->route('books');
        }
    }

    //Route::get('/comments/{id}/edit', [\App\Http\Controllers\CommentsController::class, 'edit']);
    public function edit($id){
        $comment = Comment::find($id);

        if(Auth::user() && Auth::user()->can('update', $comment, Comment::class)) {
            return view('comments/edit', ['comment' => $comment]);
        }else{
            return redirect()->route('books');
        }
    }

    //Route::patch('/comments/{id}', [\App\Http\Controllers\CommentsController::class, 'update']);
    public function update($id){
        $comment = Comment::find($id);
        $data = $this->validateData(\request());

        if(Auth::user() && Auth::user()->can('update', $comment, Comment::class)) {
            $comment->text = $data['text'];
            $comment->save();
        }

        return redirect('/books/' . $data['book_id']);
    }

    //Route::post('/comments', [\App\Http\Controllers\CommentsController::class, 'store']);
    public function store(Request $request){
        $data = $this->validateData($request);

        if((Auth::user() && Auth::user()->can('create', Comment::class)) || Auth::user() && Auth::user()->can('surf')) {
            $comment = new Comment();

            $comment->text = $data['text'];
            $comment->book_id = $data['book_id'];
            $comment->user_id = $data['user_id'];

            $comment->save();
        }

        return redirect('/books/'.$data['book_id']);
    }

    //Route::delete('/comments/{id}', [\App\Http\Controllers\CommentsController::class, 'destroy']);
    public function destroy($id){
        $comment = Comment::find($id);
        $book_id = $comment->book_id;

        if(Auth::user() && Auth::user()->can('delete', $comment, Comment::class)) {
            $comment->delete();
        }

        return redirect('/books/'.$book_id);
    }

    //VALIDATION
    private function validateData($data){
        return $this->validate($data, [
            'text' => ['required', 'min:10'],
            'book_id' => ['required'],
            'user_id' => ['required']
        ], [
            'text.required' => 'Текст коментаря має бути заповнений!',
            'text.min' => 'Текст коментаря має бути більше 10 символів!'
        ]);
    }
}
