<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //Route::get('/cart/items', [\App\Http\Controllers\ItemsController::class, 'index']);
    public function index(){
        if(Auth::user()->can('surf')) {
            //Записи, що належать даному користувачу
            $items = \auth()->user()->items->where('order_id', null);
            $total = 0;
            foreach ($items as $item){
                $total = $total + ($item->book->price * $item->quantity);
            }

            return view('items/index', ['items' => $items, 'total' => $total]);
        }else{
            return redirect()->route('books');
        }
    }

    //Route::post('/cart/items', [\App\Http\Controllers\ItemsController::class, 'store']);
    public function store(Request $request){
        if(Auth::user()->can('surf')){
            $item = new Item();
            $data = $this->validateData($request);

            $item->book_id = $data['book_id'];
            $item->user_id = $data['user_id'];
            $item->quantity = $data['quantity'];

            $item->save();

            return redirect('/cart/items');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::patch('/cart/items/{id}', [\App\Http\Controllers\ItemsController::class, 'update']);
    public function update($id){
        if(Auth::user()->can('surf')){
            $item = Item::find($id);
            $operation = \request()->input('operation');
            $quantity = $item->quantity;

            if($operation === "+"){
                $item->quantity = $quantity + 1;
            }else if($operation === "-" && $quantity > 1){
                $item->quantity = $quantity - 1;
            }else if($operation === "-"){
                $this->destroy($id);
            }

            $item->save();

            return redirect('/cart/items');
        }else{
            return redirect()->route('books');
        }
    }

    //Route::delete('/cart/items/{id}', [\App\Http\Controllers\ItemsController::class, 'destroy']);
    public function destroy($id){
        if(Auth::user()->can('surf')){
            $item = Item::find($id);
            $item->delete();

            return redirect('/cart/items');
        }else{
            return redirect()->route('books');
        }
    }

    //VALIDATION
    private function validateData($data){
        return $this->validate($data, [
            'book_id' => ['required', 'numeric'],
            'user_id' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
        ]);
    }
}
