@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse ($products as $product)
            <div class="col">
                <a href="{{url('/products/'.$product->id)}}" class="nav-link">
                    <div class="card " style="width: 18rem;">
                        <img src="{{url('storage/'.$product->image)}}" class="card-img-top card-img-fixed-size-shop" alt="product image">
                        <input class="card-id" type="hidden" value="{{$product->id}}">
                        <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5>
                        @if ($product->discount)
                            <span style="text-decoration-line: line-through">{{$product->price}}</span>
                        @endif
                        <span class="card-price">{{$product->discount?$product->price-($product->price*$product->discount/100):$product->price}}</span>
                        <div class="card-buttons mt-2">
                            @if (Auth::check())
                            <button class="btn btn-primary add-to-cart-btn" data-product-id="{{ $product->id }}" type="button">
                                <img src="{{url('images/icons/cart.svg')}}" alt="cart icon"/>
                                Add To Cart
                            </button>
                            @endif
                            @can('update', $product)
                            <a href="{{url('/products/'.$product->id.'/edit')}}"><button class="btn btn-primary" type="button">Edit</button></a>
                            @endcan
                            @can('delete', $product)
                            <a href="{{url('/products/'.$product->id.'/delete')}}"><button class="btn btn-primary" type="button">delete</button></a>
                            @endcan
                        </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            {{__("No Products Yet!")}}
        @endforelse

    </div>
</div>

@endsection
