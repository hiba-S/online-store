@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{url('/increase-balance')}}" method="post">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="balance" class="form-label">Balance</label>
            <input class="form-control @error('balance') is-invalid @enderror" type="number" id="balance" name="balance" required>
            @error('balance')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
@endsection
