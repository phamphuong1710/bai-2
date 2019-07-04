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

                    <div class="card-body">
                        <form method="POST" action="{{ url('/posts') }}"  enctype="multipart/form-data">
                            @csrf

                          <div class="form-group">
                            <label for="exampletitle">Title</label>
                            <input type="text" class="form-control" id="exampletitle" aria-describedby="emailHelp" placeholder="Enter Title" name="title">
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Example select</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="category_id">
                                  @foreach( $categories as $category )
                                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                                  @endforeach
                                </select>
                            @error('category')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                              </div>

                          <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" rows="5" id="content" name="content"></textarea>
                            @error('content')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>

                          <div class="form-group">
                            <label for="autocomplete">Address</label>
                            <input type="text" class="form-control"  aria-describedby="addresssHelp" placeholder="Enter Address" name="addresss" id="autocomplete">
                          </div>

                          <div class="row">
                              <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Thành Phố" name='city' id="administrative_area_level_1" disabled="true">
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Quận/Huyện" name="district" id="administrative_area_level_2" disabled="true">
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Phường/Xã" name="ward" id="sublocality" disabled="true">
                              </div>
                            </div>

                          <div class="form-group">

                            <input type="hidden" class="form-control" name="user_id" value="{{ Auth::id() }}">
                            @error('user_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                          </div>
                            <ul class="gallery-image-list" id="image_preview">
                            <!-- The file uploads will be shown here -->
                            </ul>
                          <div class="form-group">
                            <label for="postImage">Image</label>
                            <div class="custom">
                              <input type="file" class="custom-file-input" id="postImage" lang="in" multiple="multiple" name='image[]'>
                              <input type="hidden" name="list_image" value="" id="listImage">

                            </div>
                            <div class="custom">
                              <button type="button" class="btn btn-info btn-video">Video</button>
                            </div>
                          </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
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
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<script src="{{ asset('js/admin/jquery-ui.min.js') }}"></script>
<script>

  Array.prototype.remove = function() {
      var what, a = arguments, L = a.length, ax;
      while (L && this.length) {
          what = a[--L];
          while ((ax = this.indexOf(what)) !== -1) {
              this.splice(ax, 1);
          }
      }
      return this;
  };
      $( '#postImage' ).change( function () {
        var val = $('#listImage').val();
        var arrayImage = [];
        var position = 0;
        if ( val !== '' ) {
          arrayImage = val.split(',');
           position = arrayImage.length;
           $.each(arrayImage, function(index, value) {
              $('.image-item').each(function(){
                  if ( $(this).attr('data-item') == value ) {
                    $(this).find('.image-position').attr('val', index + 1);
                    $(this).find('.image-position').html(index + 1);
                  }
              });
           })
        }

        var fileData = $(this).prop("files");
        var formData = new FormData();
          for (var x = 0; x < fileData.length; x++) {
              formData.append("image[]", fileData[x]);
          }
        formData.append('_token', '{{csrf_token()}}');
         $.ajax({
            url: "/image",
            data: formData,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function (data) {


              $.each(data.data, function(index, value) {

                arrayImage.push(value.id);

                position = position + 1;

                $('#image_preview').append(
                    '<li data-item="' + value.id + '" class="image-item ui-sortable-handle">'
                        + '<div class="image-wrapper">'
                            + '<div class="preview-action">'
                                +'<span val="' + position + '" class="image-position">' + position
                                + '</span>'
                                + '<a href="#" class="action-delete-image fa fa-times" data-id="'+ value.id + '">'
                                + '</a>'
                                + '<span class="action-update-image  fa fa-undo"><input type="file" class="input-update" name="image" data-id="' + value.id + '">'
                                + '</span>'
                            + '</div>'
                            + '<div class="image">'
                                + '<img src={{ url("/")}}'+value.link+'>'
                            + '</div>'
                        + '</div>'
                    + '</li>'
                    );

              });

              $('#listImage').val(arrayImage);

            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });

      })


  // AJAX DELETE POST

  $(".gallery-image-list").on( 'click', '.action-delete-image', function(e){
      e.preventDefault();
      var id = $(this).attr('data-id');
      var token = $("meta[name='csrf-token']").attr("content");

      var btn = $(this);
      var val = $('#listImage').val();
      var arrayImage = [];
      if ( val !== '' ) {
        arrayImage = val.split(',');

      }
      $.ajax(
      {
          url: "/image/"+id,
          type: 'POST',
          data: {
              "_method": 'delete',
              "_token": token,
              "id": id,
          },
          success: function ($data){

              btn.parents('.image-item').remove();
              arrayImage.remove(id);
              $('#listImage').val(arrayImage);

              $.each(arrayImage, function (index, value) {
                  $('.image-item').each(function(){
                      if ( $(this).attr('data-item') == value ) {
                        $(this).find('.image-position').attr('val', index + 1);
                        $(this).find('.image-position').html(index + 1);
                      }
                  });
              });

          }
      });

  });

  $(".gallery-image-list").on('change', '.input-update', function (e) {
    e.preventDefault();
    var $this = $(this);
    var fileData = $(this).prop("files");
    var formData = new FormData();
    formData.append("image", fileData[0]);
    formData.append('_token', '{{csrf_token()}}');
    formData.append('_method', 'PUT');
    formData.append('type','post');
    var $imgID = $(this).attr('data-id');
     $.ajax({
        url: "/image/" + $imgID,
        data: formData,
        type: 'POST',
        contentType: false,
        processData: false,
        success: function (data) {
          var image = $this.parents( '.image-wrapper' ).find('img');
          image.attr('src', data.link);
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
  });

    $('.gallery-image-list').sortable({
      cursor: "move",
       update: function(event, ui) {
          var result = $(this).sortable('toArray', {attribute: 'data-item'});
          $('#listImage').val(result);
          $.each(result, function(index, value){
              $('.image-item').each(function(){
                  if ( $(this).attr('data-item') == value ) {
                    $(this).find('.image-position').attr('val', index + 1);
                    $(this).find('.image-position').html(index + 1);
                  }
              });
          })
        }
    });

    $( '.btn-video' ).on( 'click', function () {
        var video = prompt( 'Link Youtube: ' );
        var link = 'https://www.youtube.com/watch?v=';
        var start = link.length;
        var id = video.substr( start, 11 );
        var path = '/' + id +'/sddefault.jpg';
        var formData = new FormData();
        formData.append('_token', '{{csrf_token()}}');
        formData.append('image', path);
        formData.append('link', video);
          var val = $('#listImage').val();
          var arrayImage = [];
          var position = 1;
          if ( val !== '' ) {
            arrayImage = val.split(',');
            position = arrayImage.length + 1;

          }
         $.ajax({
            url: "/video",
            data: formData,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function (data) {

            console.log(data);
            arrayImage.push(data.id);
            $('#listImage').val(arrayImage);

                $('#image_preview').append(
                    '<li data-item="' + data.id + '" class="image-item ui-sortable-handle">'
                        + '<div class="image-wrapper">'
                            + '<div class="preview-action">'
                                +'<span val="' + position + '" class="image-position">' + position
                                + '</span>'
                                + '<a href="#" class="action-delete-image fa fa-times" data-id="'+ data.id + '">'
                                + '</a>'
                                + '<span class="action-update-image  fa fa-undo"><input type="file" class="input-update" name="image" data-id="' + data.id + '">'
                                + '</span>'
                            + '</div>'
                            + '<div class="image image-video">'
                                + '<img src="https://img.youtube.com/vi'+ data.image +'">'
                            + '</div>'
                        + '</div>'
                    + '</li>'
                    );


            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    } );
</script>

<script>
  var placeSearch, autocomplete;

  var componentForm = {
    administrative_area_level_1: 'long_name',
    administrative_area_level_2: 'long_name',
    sublocality_level_1: 'long_name',

  };
  function initAutocomplete() {
    // Create the autocomplete object, restricting the search predictions to
    // geographical location types.
    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById('autocomplete'), {types: ['geocode']});

    // Avoid paying for data that you don't need by restricting the set of
    // place fields that are returned to just the address components.
    autocomplete.setFields(['address_component']);

    // When the user selects an address from the drop-down, populate the
    // address fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
  }

  function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    for (var component in componentForm) {
      document.getElementById(component).value = '';
      document.getElementById(component).disabled = false;
    }

    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
      var addressType = place.address_components[i].types[0];
      if (componentForm[addressType]) {
        var val = place.address_components[i][componentForm[addressType]];
        document.getElementById(addressType).value = val;
      }
    }
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle(
          {center: geolocation, radius: position.coords.accuracy});
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=API_KEY&libraries=places&callback=initAutocomplete"
            async defer></script>
@endsection
