@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container">
                        @isset($welcomeMessage)
                            <h4>{{$welcomeMessage}}</h4>
                        @endisset
                    </div>
                    <div class="container">
                        @if (session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                             {{session('message')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endisset
                    </div>
                    
                    <div class="container">
                            <a href="{{url('/users/increase-balance')}}" class="nav-link">
                                <div class=" d-grid gap-2 py-4">
                                    <button class="btn btn-primary" type="button">Increase Balance</button>
                                </div>
                            </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

