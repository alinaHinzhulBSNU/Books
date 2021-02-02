<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use const http\Client\Curl\AUTH_ANY;

class OrderDetailsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        if(Auth::user()->can('surf')){
            $orders = \auth()->user()->orders;
            return view('profile', ['orders'=> $orders]);
        }else if(Auth::user()->can('admin') || Auth::user()->can('manage')){
            $orders = OrderDetail::all();
            return view('orders/index', ['orders' => $orders]);
        }else{
            return redirect('/books');
        }
    }

    public function create(){
        if(Auth::user()->can('surf')){
            $items = \auth()->user()->items;

            $total = 0;
            foreach ($items as $item){
                $total = $total + ($item->book->price * $item->quantity);
            }

            return view('orders/create', ['items' => $items, 'total' => $total]);
        }else{
            return redirect('/books');
        }
    }

    public function store(Request $request){
        if(Auth::user()->can('surf')){
            $order = new OrderDetail();
            $data = $this->validateData($request);

            $order->phone_number = $data['phone_number'];
            $order->city = $data['city'];
            $order->address = $data['address'];
            $order->user_id = $data['user_id'];

            //Додавання отриманого id всім елементам в корзині
            $result = OrderDetail::create($data);

            foreach (\auth()->user()->items as $item) {
                if($item->order_id === null){
                    $item->order_id = $result->id;
                    $item->save();
                }
            }

            //Зменешення кількості книг на складі
            foreach ($result->items as $item){
                $book = $item->book;
                $quantity = $book->quantity;

                if($book->quantity > $item->quantity){
                    $book->quantity = $quantity - $item->quantity;
                }else{
                    //Продати всі наявні екземпляри
                    $item->quantity = $book->quantity;
                    $item->save();

                    $book->quantity = 0;
                }

                $book->save();
            }

            return redirect('/profile/orders');
        }else{
            return redirect('/books');
        }
    }

    public function edit($id){
        if(Auth::user()->can('admin') || Auth::user()->can('manage')){
            $order = OrderDetail::find($id);
            return view('orders/edit', ['order' => $order]);
        }else{
            return redirect('/books');
        }
    }

    public function update($id){
        if(Auth::user()->can('admin') || Auth::user()->can('manage')){
            $order = OrderDetail::find($id);
            $order->status = \request()->input('status');

            $order->save();

            return redirect('/admin/orders');
        }else{
            return redirect('/books');
        }
    }

    public function destroy($id){
        if(Auth::user()->can('admin') || Auth::user()->can('manage')){
            $order = OrderDetail::find($id);
            $order->delete();

            return redirect('/admin/orders');
        }else{
            return redirect('/books');
        }
    }

    private function validateData($data){
        return $this->validate($data, [
            'phone_number' => ['required', 'numeric'],
            'city' => ['required'],
            'address' => ['required'],
            'user_id' =>['required']
        ],[
            'phone_number.required' => 'Номер телефону є обов`язковим!',
            'phone_number.numeric' => 'Номер телефону має містити лише цифри!',
            'city.required' => 'Місто є обов`язковим!',
            'address.required' => 'Адреса є обов`язковою!',
            'user_id.required' => 'Користувач є обов`язковим!'
        ]);
    }
}
