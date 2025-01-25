<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories' , ['categories' => Category::where('parent_id', null)->get() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category-form' , ['category' => new Category ,
            'categories' => Category::where('parent_id', null)->get() ,
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
            'image' => 'nullable|image',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($request->file('image')) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $imageFileName = time().".".$ext;
            $path = 'images/categories';
            $request->file('image')->move($path,$imageFileName);
            
            Category::create([
                'name' => $request->name,
                'image' => $path.'/'.$imageFileName,
                'description' => $request->description,
                'parent_id' =>  $request->parent_id,
            ]);

        }else{
            Category::create([
                'name' => $request->name,
                'description' => $request->description,
                'parent_id' =>  $request->parent_id,
            ]);
        }

        return redirect()->route('dashboard')
        ->with('message', 'Category Created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function filterProducts(Request $request)
    {
        $validated = $request->validate([
            'selectedCategories' => 'required|array',
            'selectedCategories.*' => 'nullable|number|exists:categories,id',
        ]);

        $products_ids = [];
        $category = Category::find($request->selectedCategories[0]);
        $products_ids = $this->childrenProductsIds($category);

        foreach ($request->selectedCategories as $category_id) {
            $category = Category::find($category_id);
            $categoryProductsIds = $this->childrenProductsIds($category);

            $products_ids = array_intersect($categoryProductsIds,$products_ids);
        }
        $products_ids = array_unique($products_ids);
        $products = Product::whereIn('id', $products_ids)->get();

        return redirect()->route('shop')
        ->with(['label' => 'Results' , 
            'products' => $products , 
        ]);
    }

    public function products(Category $category)
    {

        $products_ids = [];
        $products_ids = $this->childrenProductsIds($category);
        $products_ids = array_unique($products_ids);
        $products = Product::whereIn('id', $products_ids)->get();

        return view('shop' , [ 
        'products' => $products , 
        ]);
    }

    private function childrenProductsIds($category)
    {
        $products_ids = [];
        $products = $category->products;
        foreach ($products as $product) {
            array_push($products_ids , $product->id );
        }
        foreach ($category->children() as $category) {
            $categoryProductsIds = $this->childrenProductsIds($category);
            if($categoryProductsIds){
                foreach ($categoryProductsIds as $id ) {
                    array_push($products_ids , $id );
                }
            }
        }
        $products_ids = array_unique($products_ids);
        return $products_ids;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category-form' , ['category' => $category,
            'categories' => Category::where('parent_id', null)->get() ,
        ]);   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'image' => 'nullable|image',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if(!is_null($request->image)){
            $path = $category->image;
            if(File::exists($path)){
                File::delete($path);
            }
            $ext = $request->file('image')->getClientOriginalExtension();
            $imageFileName = time().".".$ext;
            $path = 'images/categories';
            $request->file('image')->move($path,$imageFileName);
            $imageFileNameWithPath = $path.'/'.$imageFileName;

        }else{
            $imageFileNameWithPath = $category->image;
        }

        $category->update([
            'name' => $request->name,
            'image' => $imageFileNameWithPath,
            'description' => $request->description,
            'parent_id' =>  $request->parent_id,
        ]);

        return redirect()->route('dashboard')
        ->with('message', 'Category Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        DB::transaction(function() use ($category) {
            DB::table('category_product')->where('product_id', $category->id)->delete();

            $path = $category->image;
            if(File::exists($path) and $path!='images/categories/default-category.svg'){
                File::delete($path);
            }  

            $category->delete();
        });
        
        return redirect()->route('dashboard')
        ->with('message', 'Category Deleted successfully!');
    }
}
