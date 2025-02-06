@forelse ($categories as $subCategory)
<div class="px-3">

<div class="accordion-item" id="{{$subCategory->name}}-collapse-area">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="{{'#'.$subCategory->name}}" aria-expanded="false" aria-controls="{{$subCategory->name}}">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="selectedCategoriesIDArray[]" value="{{$subCategory->id}}" id="{{$subCategory->name}}" {{in_array($subCategory->id,$selectedCategoriesIDArray)?'checked':''}}>
                <label class="form-check-label" for="{{$subCategory->name}}">
                    {{$subCategory->name}}
                </label>
            </div>

        </button>
    </h2>
    <div id="{{$subCategory->name}}" class="accordion-collapse collapse" data-bs-parent="#{{$subCategory->name}}-collapse-area">
        <div class="accordion-body">
            @include('admin.recursive.checkbox-sub-category', ['categories' => $subCategory->children()])
        </div>
    </div>
</div>

</div>

@empty

@endforelse
