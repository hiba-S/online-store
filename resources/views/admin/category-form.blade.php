@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{$category->id?url('/categories/'.$category->id):url('/categories')}}" method="post"  enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')??$category->name}}" required>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" cols="30" rows="5">{{old('description')??$category->description}}</textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" >
            @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Categories</label>
            <div class="accordion" id="accordionExample">
                @include('admin.recursive.radio-sub-category', ['categories' => $categories])
            </div>
            @error('parent_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
@endsection
