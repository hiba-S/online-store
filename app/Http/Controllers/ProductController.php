<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shop' , ['products' => Product::all()->sortByDesc("id")
                 ]) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product-form' , ['product' => new Product ,
            'categories' => Category::where('parent_id', null)->get() ,
            'selectedCategoriesIDArray' => [] ,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'image' => 'required|image',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'discount' => 'nullable|integer|max:100|min:0',
        ]);

        DB::transaction(function() use ($request) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $imageFileName = time().".".$ext;
            $path = 'images/categories';
            $request->file('image')->move($path,$imageFileName);

            $product = Product::create([
                'name' => $request->name,
                'image' => 'images/categories/'.$imageFileName,
                'description' => $request->description,
                'quantity' =>  $request->quantity,
                'price' =>  $request->price,
                'discount' =>  $request->discount,
            ]);
            $selectedCategories = $request->input('selectedCategoriesIDArray');
            if($selectedCategories){ 
                foreach ($selectedCategories as $category) {
                    DB::table('category_product')->insert([
                        'category_id' => $category,
                        'product_id' => $product->id
                    ]);
                }
            }
        });

        

        return redirect()->route('dashboard')
        ->with('message', 'Product Created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product' , ['product' => $product ]);
    }

    public function search(Request $request)
    {
        $products = Product::where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                ->get();
        return view('shop' , ['products' => $products , 'searchKeyword' => $request->search ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $selectedCategories=$product->categories;
        $selectedCategoriesIDArray=array();
        foreach ($selectedCategories as $category) {
            $temp = array_push($selectedCategoriesIDArray,$category->id);
        }
        return view('admin.product-form' , ['product' => $product ,
            'categories' => Category::where('parent_id', null)->get() ,
            'selectedCategoriesIDArray' => $selectedCategoriesIDArray ,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'image' => 'nullable|image',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'discount' => 'nullable|integer|max:100|min:0',
        ]);
        
        DB::transaction(function() use ($product, $request) {
            if(!is_null($request->image)){
                $path = $product->image;
                if(File::exists($path)){
                    File::delete($path);
                }
                $ext = $request->file('image')->getClientOriginalExtension();
                $imageFileName = time().".".$ext;
                $path = 'images/products';
                $request->file('image')->move($path,$imageFileName);
                $imageFileNameWithPath = $path.'/'.$imageFileName;
    
            }else{
                $imageFileNameWithPath = $product->image;
            }

            $product->update([
                'name' => $request->name,
                'image' => $imageFileNameWithPath,
                'description' => $request->description,
                'quantity' =>  $request->quantity,
                'price' =>  $request->price,
                'discount' =>  $request->discount,
            ]);
    
            $selectedCategories = $request->input('selectedCategoriesIDArray');
            DB::table('category_product')->where('product_id' , $product->id)->delete();
            if($selectedCategories){
                foreach ($selectedCategories as $categoryId) {
                    DB::table('category_product')->insert([
                        'category_id' => $categoryId,
                        'product_id' => $product->id
                    ]);
                }
            }
        });

        return redirect()->route('dashboard')
        ->with('message', 'Product Updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        DB::transaction(function() use ($product) {
            DB::table('category_product')->where('product_id', $product->id)->delete();
            DB::table('carts')->where('product_id', $product->id)->delete();
            $path = $product->image;
            if(File::exists($path)){
                File::delete($path);
            }  
            $product->delete();
        });
        
        return redirect()->route('dashboard')
        ->with('message', 'Product Deleted successfully!');
    }
}
