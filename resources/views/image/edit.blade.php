@extends('admin.home')
@section('style')
  <link href="{{ asset('css/admin/usertable.css') }}" rel="stylesheet">
@endsection
@section('sidebar')
    <li class="header">Dashboard</li>
    <!-- Optionally, you can add icons to the links -->
    <li class="active"><a href="/posts"><i class="fa fa-link"></i> <span>Post</span></a></li>
    <li><a href="{{ url('/users') }}"><i class="fa fa-user"></i><span>User</span></a></li>
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
<div class="post-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                        <div id="image_preview">

                        </div>
                        <form action="/image/{{ $images->id }}" method="POST" enctype="multipart/form-data" class="form-image">
                            @method('PUT')
                            @csrf
                          <div class="form-group">
                            <label for="postImage">Image</label>
                                <div class="custom">
                                  <input type="file" class="custom-file-input" id="postImage" lang="in" multiple="multiple" name='image'>

                                </div>
                          </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-image btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

<script>
    $( '#postImage' ).change( function () {
        $('#image_preview').html("");
        var files = $(this).prop('files');

        var total_file = files.length;

        for(var i=0;i<total_file;i++) {

            $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'>");
        }
    })
</script>

@endsection
