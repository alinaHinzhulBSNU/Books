<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublishersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //Route::get('/publishers', [\App\Http\Controllers\PublishersController::class, 'index']);
    public function index(){
        if((Auth::user() && Auth::user()->can('read', Publisher::class)) || Auth::user()->can('surf')){
            $publishers = Publisher::all()->sortBy('name');
            return view('publishers/index', ['publishers' => $publishers]);
        }else{
            return redirect()->route('books');
        }
    }

    //Route::get('/publishers/create', [\App\Http\Controllers\PublishersController::class, 'create']);
    public function create(){
        if(Auth::user() && Auth::user()->can('create', Publisher::class)){
            return view('publishers/create');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::post('/publishers', [\App\Http\Controllers\PublishersController::class, 'store']);
    public function store(Request $request){
        if(Auth::user() && Auth::user()->can('create', Publisher::class)){
            $publisher = new Publisher();
            $data = $this->validateData($request);

            $publisher->name = $data['name'];
            $publisher->description = $data['description'];
            $publisher->year = $data['year'];
            $publisher->country = $data['country'];

            $path = $request->file('logo')->store('logos', 'public');
            $publisher->logo = $path;

            $publisher->save();

            return redirect('/publishers');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::get('/publishers/{id}/edit', [\App\Http\Controllers\PublishersController::class, 'edit']);
    public function edit($id){
        if(Auth::user() && Auth::user()->can('update', Publisher::class)){
            $publisher = Publisher::find($id);
            return view('/publishers/edit', ['publisher' => $publisher]);
        }else{
            return redirect()->route('books');
        }
    }

    //Route::patch('/publishers/{id}', [\App\Http\Controllers\PublishersController::class, 'update']);
    public function update($id){
        if(Auth::user() && Auth::user()->can('update', Publisher::class)){
            $publisher = Publisher::find($id);
            $data = $this->validateDataEdit(\request());

            $publisher->name = $data['name'];
            $publisher->description = $data['description'];
            $publisher->year = $data['year'];
            $publisher->country = $data['country'];

            $request = \request();

            if($request->file('logo') != null){
                //Видалити стару картинку
                unlink(public_path('/storage/'.$publisher->logo));

                //Записати нове фото
                $path = $request->file('logo')->store('logos', 'public');
                $publisher->logo = $path;
            }

            $publisher->save();

            return redirect('/publishers');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::delete('/publishers/{id}', [\App\Http\Controllers\PublishersController::class, 'destroy']);
    public function destroy($id){
        if(Auth::user() && Auth::user()->can('delete', Publisher::class)){
            $publisher = Publisher::find($id);

            // Видалити відповідну фотографію
            unlink(public_path('/storage/'.$publisher->logo));
            $publisher->delete();

            return redirect('/publishers');
        }else{
            return redirect()->route('books');
        }
    }

    //VALIDATION
    private function validateData($data){
        return $this->validate($data, [
            'name' => ['required', 'max:100'],
            'year' => ['required', 'digits:4'],
            'country' => ['required', 'max:100'],
            'description' => ['required', 'min:10'],
            'logo' => ['required'],
        ], [
            'name.required' => 'Назва видавництва має бути заповнена!',
            'name.max' => 'Назва видавництва має бути менше 100 символів!',
            'year.required' => 'Рік заснування має бути заповнений!',
            'year.digits' => 'Неправильний формат року!',
            'country.required' => 'Країна видавництва має бути заповнена!',
            'country.max' => 'Країна видавництва має бути менше 100 символів!',
            'description.required' => 'Опис видавництва має бути заповнений!',
            'description.min' => 'Опис видавництва має бути більше 10 символів!',
            'logo.required' => 'Логотип видавництва має бути заповнений!'
        ]);
    }

    private function validateDataEdit($data){
        return $this->validate($data, [
            'name' => ['required', 'max:100'],
            'year' => ['required', 'digits:4'],
            'country' => ['required', 'max:100'],
            'description' => ['required', 'min:10']
        ], [
            'name.required' => 'Назва видавництва має бути заповнена!',
            'name.max' => 'Назва видавництва має бути менше 100 символів!',
            'year.required' => 'Рік заснування має бути заповнений!',
            'year.digits' => 'Неправильний формат року!',
            'country.required' => 'Країна видавництва має бути заповнена!',
            'country.max' => 'Країна видавництва має бути менше 100 символів!',
            'description.required' => 'Опис видавництва має бути заповнений!',
            'description.min' => 'Опис видавництва має бути більше 10 символів!'
        ]);
    }
}
