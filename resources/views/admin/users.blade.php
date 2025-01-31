@extends('layouts.app')

@section('content')
<div class="container">

<table class="table table-hover">
    <thead>
        <tr>
          <th scope="col">Image</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Role</th>
          <th scope="col">Edit User</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($users as $user)
          <tr>
            <th scope="row"><img src="{{url($user->image?'storage/'.$user->image:'images/default-avatar.png')}}" class="rounded users-img-fixed-size" alt="User Image"></th>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->role()}}</td>
            <td>
              <a href="{{url('/users/'.$user->id.'/edit')}}"><button class="btn btn-primary" type="button">Edit</button></a>
              <a href="{{url('/users/'.$user->id.'/delete')}}"><button class="btn btn-primary" type="button">Delete</button></a>
            </td>
          </tr>
        @empty
            Error Happened , No users !
        @endforelse
      </tbody>

</table>


</div>
@endsection
