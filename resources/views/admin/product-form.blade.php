@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{$product->id?url('/products/'.$product->id):url('/products')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="{{$product->id?$product->name:''}}" required>
              @error('name')
              <div class="small-alert">{{ $message }}</div>
              @enderror 
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{$product->id?$product->description:''}}</textarea>
                @error('description')
                <div class="small-alert">{{ $message }}</div>
                @enderror 
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value={{$product->id?$product->price:''}} required>
                @error('price')
                <div class="small-alert">{{ $message }}</div>
                @enderror 
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value={{$product->id?$product->quantity:''}} required>
                @error('quantity')
                <div class="small-alert">{{ $message }}</div>
                @enderror 
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input class="form-control" type="file" id="image" name="image" value={{$product->id?$product->image:''}}>
                @error('image')
                <div class="small-alert">{{ $message }}</div>
                @enderror 
            </div>
            <div class="mb-3">
                <label for="discount" class="form-label">Discount</label>
                <input type="number" class="form-control" id="discount" name="discount" value={{$product->id?$product->discount:''}}>
                <div class="small-alert">enter a number between 1 and 100 as a percentage</div>                
                @error('discount')
                <div class="small-alert">{{ $message }}</div>
                @enderror 
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Categories</label>
                <div class="accordion" id="accordionExample">
                    @include('admin.recursive.checkbox-sub-category', ['categories' => $categories]) 
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
@endsection