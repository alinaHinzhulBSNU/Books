<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRight;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //Route::get('/admin/users', [\App\Http\Controllers\UsersController::class, 'index']);
    public function index(){
        if(Gate::allows('admin')){
            $userRights = UserRight::all()->sortBy("user_id");
            return view('users/index', ['userRights' => $userRights]);
        }else{
            return redirect()->route('books');
        }
    }

    //Route::get('/admin/users/create', [\App\Http\Controllers\UsersController::class, 'create']);
    public function create(){
        if(Gate::allows('admin')) {
            $users = User::all()->sortBy('name');
            return view('users/create', ['users' => $users]);
        }else{
            return redirect()->route('books');
        }
    }

    //Route::post('/admin/users', [\App\Http\Controllers\UsersController::class, 'store']);
    public function store(Request $request){
        if(Gate::allows('admin')) {
            $userRight = new UserRight();
            $data = $this->validateData($request);

            $userRight->user_id = $data['user_id'];
            $userRight->model = $data['model'];
            $userRight->right = $data['right'];

            $userRight->save();

            return redirect('/admin/users');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::get('/admin/users/{id}/edit', [\App\Http\Controllers\UsersController::class, 'edit']);
    public function edit($id){
        if(Gate::allows('admin')) {
            $userRight = UserRight::find($id);
            $users = User::all()->sortBy('name');
            $user = $userRight->user;

            return view('users/edit', ['userRight' => $userRight, 'users' => $users, 'user' => $user]);
        }else{
            return redirect()->route('books');
        }
    }

    //Route::patch('/admin/users/{id}', [\App\Http\Controllers\UsersController::class, 'update']);
    public function update($id){
        if(Gate::allows('admin')) {
            $userRight = UserRight::find($id);
            $data = $this->validateData(\request());

            $userRight->user_id = $data['user_id'];
            $userRight->model = $data['model'];
            $userRight->right = $data['right'];

            $userRight->save();

            return redirect('/admin/users');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::delete('/admin/users/{id}', [\App\Http\Controllers\UsersController::class, 'destroy']);
    public function destroy($id){
        if(Gate::allows('admin')) {
            $userRight = UserRight::find($id);
            $userRight->delete();

            return redirect('/admin/users');
        }else{
            return redirect()->route('books');
        }
    }

    //VALIDATION
    private function validateData($data){
        return $this->validate($data, [
            'user_id' => ['required'],
            'right' => ['required'],
            'model' => ['required']
        ], [
            'user_id.required' => 'Потрібно обрати користувача!',
            'right.required' => 'Потрібно обрати право!',
            'model.required' => 'Потрібно обрати модель!',
        ]);
    }
}
