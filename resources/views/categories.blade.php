@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Categories</h2>
    @include('recursive-sub-category', ['categories' => $categories])            
</div>


@endsection

