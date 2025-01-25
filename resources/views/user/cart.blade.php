@extends('layouts.app')

@section('content')
<div class="container">
    

<table class="table ">
    {{-- table-hover --}}
    @if (session('quantityMessage'))
        <div class="alert alert-success" role="alert">
            {{ session('quantityMessage') }}
        </div>
    @endif
    @if (session('balanceMessage'))
        <div class="alert alert-success" role="alert">
            {{ session('balanceMessage') }}
        </div>
    @endif
    <thead>
        <tr>
          <th scope="col">Image</th>
          <th scope="col">Name</th>
          <th scope="col">Quantity</th>
          <th scope="col">UnitPrice</th>
          <th scope="col">SubPrice</th>
          <th scope="col">Remove</th>
        </tr>
      </thead>
      <tbody id="table-content">
        @forelse ($cart as $item)
          <tr>
            <th scope="row"><img class="users-img-fixed-size" src="{{$item->product->image}}" alt=""></th>
            <td>{{$item->product->name}}</td>
            <td>
              <input type="number" class="product-quantity" name="quantity" value="{{$item->quantity}}">
            </td>
            <td class="unit-price" >{{$item->product->discount?($item->product->price-($item->product->price*$item->product->discount/100)):$item->product->price}}</td>
            <td class="sub-total">{{($item->product->discount?($item->product->price-($item->product->price*$item->product->discount/100)):$item->product->price)*$item->quantity}}</td>
            <td>
              <a href="{{url('/delete-cart-item/'.$item->id)}}"><img src="{{url('images/icons/x-lg.svg')}}" alt=""></a>
              <input type="hidden" class="item_id" name="item_id" value="{{$item->id}}">
              <input type="hidden" class="product_id" name="product_id" value="{{$item->product->id}}">
              <input type="hidden" class="quantity" name="quantity" value="{{$item->product->id}}">
            </td>
            
          </tr>
        @empty
        <tr>
            <th scope="row">Cart Is Empty!</th>
        </tr>
        @endforelse
      </tbody>
    
</table>
<div class="container">
    @php
      $total_price = 0;
      foreach ($cart as $item) {
        if($item->product->discount){
          $total_price += ( ($item->product->price-($item->product->price*$item->product->discount/100))* $item->quantity );
        }else{
          $total_price += ($item->product->price * $item->quantity);
        }
      }
    @endphp
    <div class="card" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">Total Price</h5>
          <p class="card-text" id="total-price">{{$total_price}} SP</p>
          <form action="/placeorder" method="POST" id="place-order-form">
            @csrf
            <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
          {{-- <a href="{{url('/placeorder')}}" id="place-order-btn" class="btn btn-primary"> Place Order </a> --}}
        </div>
      </div>
  </div>

  <form action="/update-quantity" method="POST" id="update-quantity-form">
    @csrf
        <input type="hidden" name="id" id="cart-item-id" >
        <input type="hidden" name="product_id" id="cart-item-product-id" >
        <input type="hidden" name="quantity" id="cart-item-quantity" >
</form>
</div>

@endsection 