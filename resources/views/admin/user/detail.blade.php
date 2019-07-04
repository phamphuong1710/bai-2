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

<a href="/users/{{ $user->id }}/edit" class="btn-action btn-edit">Edit</a>

<h1 class="user-name">{{ $user->name }}</h1>
<span>{{ $user->email }}</span>
</div>
@endsection
