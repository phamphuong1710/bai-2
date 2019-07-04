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



                        <form action="{{ url('/image') }}" method="POST" enctype="multipart/form-data" class="form-image">
                            @csrf
                          <div class="form-group">
                            <label for="postImage">Image</label>
                                <div class="custom">
                                  <input type="file" class="custom-file-input" id="postImage" lang="in" multiple="multiple" name='image[]'>

                                </div>
                          </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-image btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>

                            <div id="image_preview"></div>
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

      var fileData = $(this).prop("files");
      console.log( fileData[0] );


      var formData = new FormData();
        for (var x = 0; x < fileData.length; x++) {
            formData.append("image[]", fileData[x]);
        }
      // formData.append("image", fileData);
      formData.append('_token', '{{csrf_token()}}');


       $.ajax({
          url: "/image",
          data: formData,
          type: 'POST',
          contentType: false,
          processData: false,
          success: function (data) {
            console.log(data);
          },
          error: function (xhr, status, error) {
              alert(xhr.responseText);
          }
      });

    })
</script>

@endsection
