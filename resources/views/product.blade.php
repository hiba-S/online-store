@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-3" style="max-width: 1/4fr;">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="{{url($product->image)}}" class="img-fluid rounded-start" alt="product image">
          </div>
          <div class="col-md-8">
            <div class="card-body mx-4">
              <h3 class="card-title pt-5">Name : {{$product->name}}</h3>
              <p class="card-text py-3">{{$product->description?$product->description:"No Description Available!"}}</p>
              <p class="card-text py-3">Price : 
                @if ($product->discount)
                    <span style="text-decoration-line: line-through">{{$product->price}}</span>
                    <span>{{$product->price*$product->discount/100}}</span>
                @else
                    <span>{{$product->price}}</span>                    
                @endif  
              </p>
              <p class="card-text py-3">Quantity : {{$product->quantity}}</p>
              @if (Auth::check())
                <a href="" class="btn btn-primary"><img src = "{{url('images/icons/cart.svg')}}" alt="cart icon"/> Add To Cart </a>
              @endif
            </div>
          </div>
        </div>
      </div>
</div>
@endsection