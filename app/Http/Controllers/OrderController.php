<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $orders = Order::all()->sortByDesc("id");
        foreach ($orders as $order) {
            $order->details = json_decode($order->details);
        }
        return view('user.orders' , ['orders' => $orders ]);
    }

    public function myOrders(Request $request)
    {
        $user = Auth::user();
        $orders = Order::where('user_id',$user->id)
                            ->orderBy('id', 'desc')
                            ->get();
        foreach ($orders as $order) {
            $order->details = json_decode($order->details);
        }
        return view('user.orders' , ['orders' => $orders ,
            ]) ;
    }


    public function store(Request $request)
    {

        $cart = Cart::where('user_id',Auth::user()->id)->get();

        $totalPrice = 0;
        $quantityMessage = "";
        foreach ($cart as $item) {
            if($item->quantity > $item->product->quantity){
                $quantityMessage = $quantityMessage . "there is no enough " .$item->product->title . " in stock , ";
            }
            $totalPrice +=( ($item->product->price-($item->product->price*$item->product->discount/100)) * $item->quantity);
        }

        if($quantityMessage != ""){
            return redirect()->back()->with('quantityMessage', $quantityMessage);
        }

        $user = Auth::user();

        $oldBalance = $user->balance;
        $newBalance = $oldBalance - $totalPrice;

        if($newBalance < 0){
            return redirect()->back()->with('balanceMessage', 'Sorry! no enough balance');

        }

        foreach ($cart as $item) {
                $tempProduct = Product::find($item->product->id);
                $tempProduct->quantity -= $item->quantity;

                $item->product_name = $tempProduct->name;
                $item->product_price = $tempProduct->price-($tempProduct->price*$tempProduct->discount/100);

                $user = Auth::user();
                $user->balance = $newBalance ;

                $item->save();
                $tempProduct->save();
                $user->save();
                
        }

        $order = new Order;

        $order->details = json_encode($cart);
        $order->total_price = $totalPrice;

        $order->user_id = $user->id;
        $order->save();

        foreach ($cart as $item) {
            $tempCart = Cart::find($item->id)->delete();
        }

        $orders = Order::where('user_id',$user->id)->get()->sortByDesc("id");
        foreach ($orders as $order) {
            $order->details = json_decode($order->details);
        }
        return view('user.orders', ['message' => 'Payment completed Successfully',
            'old-balance' => $oldBalance ,
            'new-balance' => $newBalance ,
            'orders' => $orders ,
            ]);
    }

    public function destroy(Request $request, Order $order)
    { 
        $order->delete();
        
        return redirect()->route('dashboard')
        ->with('message', 'Order Bill Deleted successfully!');
    }

}