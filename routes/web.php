<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $latestProducts = Product::all()->sortByDesc("id")->take(6);
    $discounts = Product::where('discount',">","0")->get()->sortByDesc("discount");
    return view('index' , ['latestProducts' => $latestProducts , 'discounts' => $discounts] );
});

Auth::routes();



Route::group(['middleware'=>'auth'] , function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::middleware(['isAdmin'])->group(function(){

        Route::get('/products/create', [ProductController::class,'create']);
        Route::get('/products/{product}/edit', [ProductController::class,'edit']);
        Route::post('/products',[ProductController::class,'store']);
        Route::post('/products/{product}',[ProductController::class,'update']);
        Route::get('/products/{product}/delete',[ProductController::class,'destroy']);

        Route::get('/categories/create', [CategoryController::class,'create']);
        Route::get('/categories/{category}/edit', [CategoryController::class,'edit']);
        Route::post('/categories',[CategoryController::class,'store']);
        Route::post('/categories/{category}',[CategoryController::class,'update']);
        Route::get('/categories/{category}/delete',[CategoryController::class,'destroy']);

        Route::get('/users', [UserController::class,'index']);
        Route::get('/users/{user}/edit', [UserController::class,'edit']);
        Route::post('/users/{user}',[UserController::class,'update']);

    });

    Route::middleware(['isCashier'])->group(function(){

        Route::get('/users/increase-balance', [UserController::class,'balanceForm']);
        Route::post('/increase-balance', [UserController::class,'increasaBalance']);

    });


    Route::get('/cart', function () {
        return view('user.cart');
    });

    Route::get('/cart',[CartController::class,'showCart']);
    Route::get('/cart/count', [CartController::class, 'getCartCount']);
    Route::post('/add-to-cart/{product_id}',[CartController::class,'store']);
    Route::post('/update-quantity',[CartController::class,'update']);
    Route::get('/delete-cart-item/{cart}',[CartController::class,'destroy']);
    Route::get('/empty-cart',[CartController::class,'destroyCart']);

    Route::post('/placeorder',[OrderController::class,'store']);
    Route::get('/myorders',[OrderController::class,'myOrders']);
    Route::get('/orders',[OrderController::class,'index']);
    Route::get('/orders/{order}/delete',[OrderController::class,'destroy']);

});

Route::get('/search', [ProductController::class,'search']);
Route::get('/shop', [ProductController::class,'index']);
Route::get('/products/{product}', [ProductController::class,'show']);

Route::get('/categories', [CategoryController::class,'index']);
Route::get('/categories/{category}/products', [CategoryController::class,'products']);
Route::get('/categories/filter', [CategoryController::class,'filterProducts']);
