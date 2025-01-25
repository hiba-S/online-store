<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::check()){
            switch (Auth::user()->role()){
                case "User":
                    $latestProducts = Product::all()->sortByDesc("id")->take(8);
                    $discounts = Product::all()->sortByDesc("discount");
                    return view('index' , ['welcomeMessage' => 'welcome '.Auth::user()->name, 'latestProducts' => $latestProducts , 'discounts' => $discounts] );
                    break;
                case "Admin":
                return redirect()->route('dashboard')
                ->with(['welcomeMessage' => 'welcome Admin '.Auth::user()->name]);
                    break;
                case "Cashier":
                    return redirect()->route('dashboard')
                    ->with(['welcomeMessage' => 'welcome Cashier '.Auth::user()->name]);
                    break;
            }
        }else {
            abort(403);
        }
    }

    public function dashboard()
    {
        if(Auth::check()){
            switch (Auth::user()->role()){
                case "User":
                    abort(403);
                    break;
                case "Admin":
                    return view('admin.dashboard' , ['welcomeMessage' => 'welcome Admin '.Auth::user()->name]);
                    break;
                case "Cashier":
                    return view('cashier.dashboard' , ['welcomeMessage' => 'welcome Cashier '.Auth::user()->name]);
                    break;
            }
        }else {
            abort(403);
        }
    }
}
