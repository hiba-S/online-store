@extends('layouts.app')

@section('content')

<div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <div
        class="col-10 col-sm-8 col-lg-6">
        <img src="{{url('images/hero.svg')}}" class="d-block mx-lg-auto img-fluid" alt="Sopping Image" width="700" height="500" loading="lazy">
        </div>
        <div class="col-lg-6">
        <h1 class="display-5 fw-bold lh-1 mb-3">Great Shopping Experience Is Waiting For You!</h1>
        <p class="lead">you cen search for products by product name or see different choices in a particular category or filter products in our multi layer category system , all that for you to find the product you want in an easy and fast way ..</p>
        <p class="lead"> Hope you enjoy ... </p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <a href="{{url('/shop')}}"><button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Start Shopping</button></a>
            <a href="{{url('/categories')}}"><button type="button" class="btn btn-outline-secondary btn-lg px-4">See Categories</button></a>
        </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <h2 class="pb-4">Our Latest Products</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse ($latestProducts as $product)
            <div class="col">
                <a href="{{url('/products/'.$product->id)}}" class="nav-link">
                    <div class="card " style="width: 18rem;">
                        <img src="{{url($product->image)}}" class="card-img-top card-img-fixed-size-shop" alt="product image">
                        <div class="card-body">
                            <div class="card-id" hidden>{{$product->id}}</div>
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

<div class="container py-4">
<h2 class="pb-4">Discounts</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse ($discounts as $product)
            <div class="col">
                <a href="{{url('/products/'.$product->id)}}" class="nav-link">
                    <div class="card " style="width: 18rem;">
                        <img src="{{url($product->image)}}" class="card-img-top card-img-fixed-size-shop" alt="product image">
                        <div class="card-body">
                            <div class="card-id" hidden>{{$product->id}}</div>
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
            {{__("No Discounts Now!")}}
        @endforelse

    </div>
</div>



@endsection
