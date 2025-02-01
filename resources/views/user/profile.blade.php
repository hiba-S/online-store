@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container">
        @isset($message)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{$message}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endisset
    </div>
    <img src="{{url($user->image?'storage/'.$user->image:'images/default-avatar.png')}}" class="rounded-circle" alt="Profile Image">
    <form action="{{url('/users/'.$user->id)}}" method="post"  enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')??$user->name}}" required>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')??$user->email}}" required>
            @error('email')
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

        @can('changeRole', Auth::user())
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select @error('role') is-invalid @enderror" aria-label=""  name="role" id="role">
                <option {{(old('role')??$user->role)==1?"selected":""}} name="role" value="1">Admin</option>
                <option {{(old('role')??$user->role)==2?"selected":""}} name="role" value="2">Cashier</option>
                <option {{(old('role')??$user->role)==0?"selected":""}} name="role" value="0">User</option>
            </select>
            @error('role')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        @endcan

        @can('increaseBalance', Auth::user())
        <div class="mb-3">
            <label for="balance" class="form-label">Balance</label>
            <input type="number" class="form-control @error('balance') is-invalid @enderror" id="balance" name="balance" value="{{old('balance')??$user->balance}}" required>
            @error('balance')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        @else
        <div class="mb-3">
        <fieldset disabled>
            <label for="balance" class="form-label">Balance</label>
            <input type="number" class="form-control" id="balance" name="balance" value={{$user->balance}} required>
        </fieldset>
        </div>
        @endcan

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Change your password">
            @error('password')
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
