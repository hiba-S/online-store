@forelse ($categories as $category)
<div class="px-4">
    <a href="{{url('/categories/'.$category->id.'/products')}}" class='nav-link'> 
    <div class="card mb-3 ml-3">
        <div class="row g-0">
        <div class="col-md-4 py-1">
            <img src="{{url($category->image)}}" class="img-fluid rounded-start card-img-fixed-size" alt="category image">
        </div>
        <div class="col-md-7">
            <div class="card-body mx-4">
            <h3 class="card-title pt-5">{{$category->name}}</h3>
            <p class="card-text py-3">{{$category->description}}</p>
            @can('update', $category)
                <a href="{{url('/categories/'.$category->id.'/edit')}}"><button class="btn btn-primary" type="button">Edit</button></a>
            @endcan
            @can('delete', $category)
                <a href="{{url('/categories/'.$category->id.'/delete')}}"><button class="btn btn-primary" type="button">delete</button></a>
            @endcan
            </div>
        </div>
        </div>
    </div>
    </a>

    @include('recursive-sub-category', ['categories' => $category->children()])        
</div>

@empty
    
@endforelse