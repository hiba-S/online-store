@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row row-cols-1 row-cols-md-2 g-3">
        @forelse ($orders as $order)
            <div class="col">

                <div class="card" style="width: 30rem;">
                    <div class="card-body">
                    <h5 class="card-title">ID : {{$order->id}} </h5>
                    <h6>details</h6>
                    @foreach ($order->details as $item)
                        <p>id : {{$item->product_id}} , title : {{$item->product_name}} , price : {{$item->product_price}} , quantity : {{$item->quantity}}</p>                    
                    @endforeach
                    <p>Total Price : {{$order->total_price}} </p>
                    @can('delete', $order)
                        <a href="{{url('/orders/'.$order->id.'/delete')}}"><button class="btn btn-primary" type="button">delete</button></a>
                    @endcan
                    </div>
                </div>

            </div>
        @empty
            {{__("No Orders Yet!")}}
        @endforelse
    
    </div>
</div>


@endsection