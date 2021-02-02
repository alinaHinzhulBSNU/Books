<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\False_;

class BooksController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //Route::get('/books', [\App\Http\Controllers\BooksController::class, 'index']);
    public function index(){
        if((Auth::user() && Auth::user()->can('read', Book::class)) || Gate::allows('surf')){
            $books = Book::all()->sortBy('name');
            return view('books/index', $this->values($books));
        }else{
            return redirect()->route('login');
        }
    }

    //Route::get('/books/create', [\App\Http\Controllers\BooksController::class, 'create']);
    public function create(){
        if(Auth::user() && Auth::user()->can('create', Book::class)){
            $genres = Genre::all()->sortBy('name');
            $publishers = Publisher::all()->sortBy('name');
            $authors = Author::all()->sortBy('name');

            return view('books/create', ['genres' => $genres, 'publishers' => $publishers, 'authors' => $authors]);
        }else{
            return redirect()->route('books');
        }
    }

    //Route::post('/books', [\App\Http\Controllers\BooksController::class, 'store']);
    public function store(Request $request){
        if(Auth::user() && Auth::user()->can('create', Book::class)){
            $book = new Book();
            $data = $this->validateData($request);

            $book->name = $data['name'];
            $book->language = $data['language'];
            $book->year = $data['year'];
            $book->author_id = $data['author_id'];
            $book->publisher_id = $data['publisher_id'];
            $book->genre_id = $data['genre_id'];
            $book->quantity = $data['quantity'];
            $book->price = $data['price'];
            $book->description = $data['description'];

            $path = $request->file('cover')->store('covers', 'public');
            $book->cover = $path;

            $book->save();

            return redirect('/books');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::get('/books/{id}/edit', [\App\Http\Controllers\BooksController::class, 'edit']);
    public function edit($id){
        if(Auth::user() && Auth::user()->can('update', Book::class)){
            $genres = Genre::all()->sortBy('name');
            $publishers = Publisher::all()->sortBy('name');
            $authors = Author::all()->sortBy('name');

            $book = Book::find($id);

            return view('books/edit', ['book' => $book, 'genres' => $genres, 'publishers' => $publishers, 'authors' => $authors]);
        }else{
            return redirect()->route('books');
        }
    }

    //Route::patch('/books/{id}', [\App\Http\Controllers\BooksController::class, 'update']);
    public function update($id){
        if(Auth::user() && Auth::user()->can('update', Book::class)){
            $book = Book::find($id);
            $data = $this->validateDataEdit(\request());

            $book->name = $data['name'];
            $book->language = $data['language'];
            $book->year = $data['year'];
            $book->author_id = $data['author_id'];
            $book->publisher_id = $data['publisher_id'];
            $book->genre_id = $data['genre_id'];
            $book->quantity = $data['quantity'];
            $book->price = $data['price'];
            $book->description = $data['description'];

            $request = \request();

            if($request->file('cover') != null){
                //Видалити стару картинку
                unlink(public_path('/storage/'.$book->cover));

                //Записати нове фото
                $path = $request->file('cover')->store('covers', 'public');
                $book->cover = $path;
            }

            $book->save();

            return redirect('/books');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::get('/books/{id}', [\App\Http\Controllers\BooksController::class, 'show']);
    public function show($id){
        if((Auth::user() && Auth::user()->can('read', Book::class)) || Gate::allows('surf')){
            $book = Book::find($id);
            return view('books/show', ['book' => $book]);
        }else{
            return redirect()->route('books');
        }
    }

    //Route::delete('/books/{id}', [\App\Http\Controllers\BooksController::class, 'destroy']);
    public function destroy($id){
        if(Auth::user() && Auth::user()->can('delete', Book::class)){
            $book = Book::find($id);

            // Видалити відповідну фотографію
            unlink(public_path('/storage/'.$book->cover));
            $book->delete();

            return redirect('/books');
        }else{
            return redirect()->route('books');
        }
    }

    //FILTERS
    public function authorFilter($id){
        if((Auth::user() && Auth::user()->can('read', Book::class)) || Gate::allows('surf')){
            $author = Author::find($id);
            $books = $author->books;

            return view('books/index', $this->values($books));
        }else{
            return redirect()->route('login');
        }
    }

    public function publisherFilter($id){
        if((Auth::user() && Auth::user()->can('read', Book::class)) || Gate::allows('surf')){
            $publisher = Publisher::find($id);
            $books = $publisher->books;

            return view('books/index', $this->values($books));
        }else{
            return redirect()->route('login');
        }
    }

    public function genreFilter($id){
        if((Auth::user() && Auth::user()->can('read', Book::class)) || Gate::allows('surf')){
            $genre = Genre::find($id);
            $books = $genre->books;

            return view('books/index', $this->values($books));
        }else{
            return redirect()->route('login');
        }
    }

    //SEARCH
    public function search(Request $request){
        if((Auth::user() && Auth::user()->can('read', Book::class)) || Gate::allows('surf')){
            $books = Book::all();
            $name =  $request->input('name');

            if($name){
                $found_books = array();

                foreach ($books as $book){
                    if(mb_stristr($book->name, $name, false, 'UTF-8') !== false){
                        array_push($found_books, $book);
                    }
                }

                return view('books/index', $this->values($found_books));
            }

            return view('books/index', $this->values($books));
        }else{
            return redirect()->route('login');
        }
    }

    //VALIDATION
    private function validateData($data){
        return $this->validate($data, [
            'name' => ['required', 'max:100'],
            'language' => ['required', 'max:100'],
            'year' => ['required', 'digits:4'],
            'author_id' => ['required'],
            'publisher_id' => ['required'],
            'genre_id' => ['required'],
            'quantity' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'min:10'],
            'cover' => ['required'],
        ], [
            'author_id.required' => 'Автор має бути обраний!',
            'publisher_id.required' => 'Видавництво має бути обране!',
            'genre_id.required' => 'Жанр має бути обраний!',
            'name.required' => 'Назва книги має бути заповнена!',
            'name.max' => 'Назва книги має бути менше 100 символів!',
            'language.required' => 'Мова має бути заповнена!',
            'language.max' => 'Мова має бути менше 100 символів!',
            'year.required' => 'Рік видання має бути заповнений!',
            'year.digits' => 'Неправильний формат року!',
            'quantity.required' => 'Кількість книг має бути заповнена!',
            'quantity.numeric' => 'Кількість книг має бути числом!',
            'price.required' => 'Ціна має бути заповнена!',
            'price.numeric' => 'Ціна книг має бути числом!',
            'description.required' => 'Опис книги має бути заповнений!',
            'description.min' => 'Опис книги має бути більше 10 символів!',
            'cover.required' => 'Фотографія обкладинки має бути обрана!',
        ]);
    }

    private function validateDataEdit($data){
        return $this->validate($data, [
            'name' => ['required', 'max:100'],
            'language' => ['required', 'max:100'],
            'year' => ['required', 'digits:4'],
            'author_id' => ['required'],
            'publisher_id' => ['required'],
            'genre_id' => ['required'],
            'quantity' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'min:10']
        ], [
            'author_id.required' => 'Автор має бути обраний!',
            'publisher_id.required' => 'Видавництво має бути обране!',
            'genre_id.required' => 'Жанр має бути обраний!',
            'name.required' => 'Назва книги має бути заповнена!',
            'name.max' => 'Назва книги має бути менше 100 символів!',
            'language.required' => 'Мова має бути заповнена!',
            'language.max' => 'Мова має бути менше 100 символів!',
            'year.required' => 'Рік видання має бути заповнений!',
            'year.digits' => 'Неправильний формат року!',
            'quantity.required' => 'Кількість книг має бути заповнена!',
            'quantity.numeric' => 'Кількість книг має бути числом!',
            'price.required' => 'Ціна має бути заповнена!',
            'price.numeric' => 'Ціна книг має бути числом!',
            'description.required' => 'Опис книги має бути заповнений!',
            'description.min' => 'Опис книги має бути більше 10 символів!'
        ]);
    }

    //ДОПОМІЖНІ ФУНКЦІЇ
    private function values($books){
        $genres = Genre::all()->sortBy('name');
        $publishers = Publisher::all()->sortBy('name');
        $authors = Author::all()->sortBy('name');

        return ['books' => $books, 'genres' => $genres, 'publishers' => $publishers, 'authors' => $authors];
    }
}
