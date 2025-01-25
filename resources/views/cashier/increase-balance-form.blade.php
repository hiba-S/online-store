@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{url('/increase-balance')}}" method="post">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
          @error('balance')
            <div class="small-alert">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
            <label for="balance" class="form-label">Balance</label>
            <input class="form-control" type="number" id="balance" name="balance" required>
            @error('balance')
            <div class="small-alert">{{ $message }}</div>
            @enderror 
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
@endsection