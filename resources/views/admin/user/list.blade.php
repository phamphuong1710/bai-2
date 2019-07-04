@extends('admin.home')
@section('style')
  <link href="{{ asset('css/admin/usertable.css') }}" rel="stylesheet">
@endsection
@section('sidebar')
    <li class="header">Dashboard</li>
    <!-- Optionally, you can add icons to the links -->
    <li><a href="/posts"><i class="fa fa-link"></i> <span>Post</span></a></li>
    <li class="active"><a href="{{ url('/users') }}"><i class="fa fa-user"></i><span>User</span></a></li>
    <li class="treeview">
      <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="#">Link in level 2</a></li>
        <li><a href="#">Link in level 2</a></li>
      </ul>
    </li>
@endsection
@section('content')

<div class="user-section">


    <div class="table-users">

    <h1 class="page-title header">User</h1>
    <a href="/users/create" class="create">Create User</a>
       <table cellspacing="0">
            <tr>
                <th>Picture</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>

            @foreach( $users as $user )
              <tr>
                 <td><a href="/users/{{ $user->id }}"><img src="{{ url('/').'/images/user.png' }}" alt="user" /></a></td>
                 <td><a href="/users/{{ $user->id }}">{{ $user->name }}</a></td>
                 <td>{{ $user->email }}</td>
                 <td>
                     <a href="/users/{{ $user->id }}/edit" class="btn-action btn-edit">Edit</a>
                     <form action="/users/{{ $user->id }}" method="POST" class="form-delete">
                            @method('delete')
                            {{ csrf_field() }}
                         <button type="submit" class="btn-action btn-delete">Delete</button>
                     </form>

                 </td>
              </tr>
            @endforeach


       </table>
    </div>
</div>
@endsection
