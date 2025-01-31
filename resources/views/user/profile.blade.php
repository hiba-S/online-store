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
          <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" type="file" id="image" name="image" >
            @error('image')
            <div class="small-alert">{{ $message }}</div>
            @enderror
        </div>

        @can('changeRole', Auth::user())
        <div class="mb-3">
            <label for="image" class="form-label">Role</label>
            <select class="form-select" aria-label=""  name="role" id="role">
                <option {{$user->role==1?"selected":""}} name="role" value="1">Admin</option>
                <option {{$user->role==2?"selected":""}} name="role" value="2">Cashier</option>
                <option {{$user->role==0?"selected":""}} name="role" value="0">User</option>
            </select>
        </div>
        @endcan

        @can('increaseBalance', Auth::user())
        <div class="mb-3">
            <label for="balance" class="form-label">Balance</label>
            <input type="number" class="form-control" id="balance" name="balance" value={{$user->balance}} required>
            @error('balance')
            <div class="small-alert">{{ $message }}</div>
            @enderror
        </div>
        @else
        <div class="mb-3">
        <fieldset disabled>
            <label for="balance" class="form-label">Balance</label>
            <input type="number" class="form-control" id="balance" name="balance" value={{$user->balance}} required>
            @error('balance')
            <div class="small-alert">{{ $message }}</div>
            @enderror
        </fieldset>
        </div>
        @endcan

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Change your password">
            @error('password')
                <div class="small-alert">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
@endsection
