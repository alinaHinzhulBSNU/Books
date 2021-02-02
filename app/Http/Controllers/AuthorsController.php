<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use phpDocumentor\Reflection\DocBlock\Tags\Author;
use App\Models\Author;
use Illuminate\Support\Facades\Auth;

class AuthorsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    //Route::get('/authors', [\App\Http\Controllers\AuthorsController::class, 'index']);
    public function index(){
        if((Auth::user() && Auth::user()->can('read', Author::class)) || Auth::user()->can('surf', Author::class)){
            $authors = Author::all()->sortBy('name');
            return view('authors/index', ['authors' => $authors]);
        }else{
            return redirect()->route('books');
        }
    }

    //Route::get('/authors/create', [\App\Http\Controllers\AuthorsController::class, 'create']);
    public function create(){
        if(Auth::user() && Auth::user()->can('create', Author::class)){
            return view('authors/create');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::post('/authors', [\App\Http\Controllers\AuthorsController::class, 'store']);
    public function store(Request $request){
        if(Auth::user() && Auth::user()->can('create', Author::class)){
            $author = new Author();
            $data = $this->validateData($request);

            $author->name = $data['name'];
            $path = $request->file('photo')->store('photos', 'public');
            $author->photo = $path;
            $author->biography = $data['biography'];

            $author->save();

            return redirect('/authors');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::get('/authors/{id}/edit', [\App\Http\Controllers\AuthorsController::class, 'edit']);
    public function edit($id){
        if(Auth::user() && Auth::user()->can('update', Author::class)){
            $author = Author::find($id);
            return view('authors/edit', ['author' => $author]);
        }else{
            return redirect()->route('books');
        }
    }

    //Route::patch('/authors/{id}', [\App\Http\Controllers\AuthorsController::class, 'update']);
    public function update($id){
        if(Auth::user() && Auth::user()->can('update', Author::class)){
            $author = Author::find($id);
            $data = $this->validateDataEdit(\request());

            $author->name = $data['name'];
            $author->biography = $data['biography'];

            $request = \request();

            if($request->file('photo') != null){
                //Видалити стару картинку
                unlink(public_path('/storage/'.$author->photo));

                //Записати нове фото
                $path = $request->file('photo')->store('photos', 'public');
                $author->photo = $path;
            }

            $author->save();

            return redirect('/authors');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::delete('/authors/{id}', [\App\Http\Controllers\AuthorsController::class, 'destroy']);
    public function destroy($id){
        if(Auth::user() && Auth::user()->can('delete', Author::class)){
            $author = Author::find($id);

            // Видалити відповідну фотографію
            unlink(public_path('/storage/'.$author->photo));
            $author->delete();

            return redirect('/authors');
        }else{
            return redirect()->route('books');
        }
    }

    //VALIDATION
    private function validateData($data){
        return $this->validate($data, [
            'name' => ['required', 'max:100'],
            'biography' => ['required', 'min:10'],
            'photo' => ['required'],
        ], [
            'name.required' => 'Імя автора має бути заповнене!',
            'name.max' => 'Імя автора має бути менше 100 символів!',
            'biography.required' => 'Біографія автора має бути заповнена!',
            'biography.min' => 'Біографія автора має бути більше 10 символів!',
            'photo.required' => 'Фотографія автора має бути обрана!'
        ]);
    }
    private function validateDataEdit($data){
        return $this->validate($data, [
            'name' => ['required', 'max:100'],
            'biography' => ['required', 'min:10']
        ], [
            'name.required' => 'Імя автора має бути заповнене!',
            'name.max' => 'Імя автора має бути менше 100 символів!',
            'biography.required' => 'Біографія автора має бути заповнена!',
            'biography.min' => 'Біографія автора має бути більше 10 символів!'
        ]);
    }
}
