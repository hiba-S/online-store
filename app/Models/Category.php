<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'image', 'description', 'parent_id',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class ,'category_product', 'category_id', 'product_id');
    }

    public function children()
    {
        return Category::where('parent_id',$this->id)->get() ;   
    }

}
