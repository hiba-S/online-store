@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{$category->id?url('/categories/'.$category->id):url('/categories')}}" method="post"  enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name" value="{{$category->id?$category->name:''}}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{$category->id?$category->description:''}}</textarea>
            @error('description')
            <div class="small-alert">{{ $message }}</div>
            @enderror 
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" type="file" id="image" name="image" >
            @error('image')
            <div class="small-alert">{{ $message }}</div>
            @enderror 
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Categories</label>
            <div class="accordion" id="accordionExample">
                @include('admin.recursive.radio-sub-category', ['categories' => $categories]) 
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
@endsection