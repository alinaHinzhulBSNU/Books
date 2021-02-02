<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GenresController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //Route::get('/genres', [\App\Http\Controllers\GenresController::class, 'index']);
    public function index(){
        if((Auth::user() && Auth::user()->can('read', Genre::class)) || Auth::user()->can('surf')) {
            $genres = Genre::all()->sortBy('name');
            return view('genres/index', ['genres' => $genres]);
        }else{
            return redirect()->route('books');
        }
    }

    //Route::get('/genres/create', [\App\Http\Controllers\GenresController::class, 'create']);
    public function create(){
        if(Auth::user() && Auth::user()->can('create', Genre::class)) {
            return view('genres/create');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::post('/genres', [\App\Http\Controllers\GenresController::class, 'store']);
    public function store(Request $request){
        if(Auth::user() && Auth::user()->can('create', Genre::class)) {
            $genre = new Genre();
            $data = $this->validateData($request);

            $genre->name = $data['name'];
            $genre->description = $data['description'];

            $genre->save();

            return redirect('/genres');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::get('/genres/{id}/edit', [\App\Http\Controllers\GenresController::class, 'edit']);
    public function edit($id){
        if(Auth::user() && Auth::user()->can('update', Genre::class)) {
            $genre = Genre::find($id);
            return view('genres/edit', ['genre' => $genre]);
        }else{
            return redirect()->route('books');
        }
    }

    //Route::patch('/genres/{id}', [\App\Http\Controllers\GenresController::class, 'update']);
    public function update($id){
        if(Auth::user() && Auth::user()->can('update', Genre::class)) {
            $genre = Genre::find($id);
            $data = $this->validateData(\request());

            $genre->name = $data['name'];
            $genre->description = $data['description'];

            $genre->save();

            return redirect('/genres');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::delete('/genres/{id}', [\App\Http\Controllers\GenresController::class, 'destroy']);
    public function destroy($id){
        if(Auth::user() && Auth::user()->can('delete', Genre::class)) {
            $genre = Genre::find($id);
            $genre->delete();
            return redirect('/genres');
        }else{
            return redirect()->route('books');
        }
    }

    //VALIDATION
    private function validateData($data){
        return $this->validate($data, [
            'name' => ['required', 'max:100'],
            'description' => ['required', 'min:10'],
        ], [
            'name.required' => 'Назва жанру має бути заповнена!',
            'name.max' => 'Назва жанру має бути менше 100 символів!',
            'description.required' => 'Опис жанру має бути заповнений!',
            'description.min' => 'Опис жанру має бути більше 10 символів!'
        ]);
    }
}
