<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function showCart(Request $request)
    {
        return view('user.cart' , ['cart' => Cart::where('user_id',Auth::user()->id)->get() ,
        ]) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($product_id)
    {
        $cartItems = Cart::where('user_id',Auth::user()->id)->get();
        $existsFlag = false;
        foreach ($cartItems as $item) {
            if ($item->product_id == $product_id) {
                $item->quantity++;
                $item->save();
                $existsFlag = true;
                break;
            }
        }
        if (!$existsFlag) {
            Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $product_id,
                'quantity' => "1",
            ]);
        }

        return redirect()->back()->with('message', 'Cart item Added successfully!');;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cartItem = Cart::where('id',$request->id)->first();
        $cartItem->quantity=$request->quantity;
        $cartItem->product_id=$request->product_id;
        $cartItem->user_id=Auth::user()->id;
        $cartItem->save();

        return redirect()->back()->with('message', 'Cart item Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , Cart $cart)
    {
        $cart->delete();
        return redirect()->back()->with('message', 'Cart item Deleted successfully!');
    }

    public function destroyCart(Request $request)
    {
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        foreach ($cart as $item) {
            $item->delete();
        }
        return view('user.cart' , ['cart' => Cart::where('user_id',Auth::user()->id)->first() , 
        ]);
    }
}
