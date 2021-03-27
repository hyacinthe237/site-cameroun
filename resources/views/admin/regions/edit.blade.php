@extends('admin.body')

@section('head')
    <link rel="stylesheet" type="text/css" href="/backend/fancybox/jquery.fancybox.css" media="screen" />
@endsection

@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('regions.index') }}" class="btn btn-lg btn-teal">
                <i class="ion-reply"></i> Cancel
            </a>
        </div>

        <div class="title">
            Edit Région
        </div>
    </div>



    <section class="container-fluid mt-20">
      {!! Form::model($region, ['method' => 'PUT', 'route' => ['regions.update', $region->id], 'class' => '_form' ]) !!}

        @include('errors.list')

        {{ csrf_field() }}

        <div class="block">
            <div class="block-content form">
                  <div class="row mt-20">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" id="slug-source" name="name" class="form-control input-lg" value="{{ $region->name }}" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" id="slug-target" class="form-control input-lg" value="{{ $region->slug }}" required readonly>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Mots cles</label>
                            <input type="text" name="tags" class="form-control input-lg tags" value="{{ $region->tags }}" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Longitude</label>
                            <input type="text" name="lon" class="form-control input-lg" value="{{ $region->lon }}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Latitude</label>
                            <input type="text" name="lat" class="form-control input-lg" value="{{ $region->lat }}">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <h5 class="mt-20">Image</h5>

                        <input type="hidden" class="form-control" id='profile' name='image' readonly value="{{ $region->image }}">
                        <div id="profile_view" class="mt-20"></div>

                        <div class="text-right">
                            <a href="/backend/filemanager/dialog.php?type=1&field_id=profile" class="iframe-btn btn-dark btn round"> <i class='ion-folder'></i> Files</a>
                        </div>

                        <div class="form-group text-right mt-20">
                            <button type="submit" class="btn btn-lg btn-primary">
                                <i class="ion-checkmark"></i> Enregistrer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      {!! Form::close() !!}
@endsection

@section('js')
<script type="text/javascript" src="/backend/js/scripts.js"></script>
<script type="text/javascript" src="/backend/fancybox/jquery.fancybox.js"></script>
<script>
$(document).ready(function() {
  $('#slug-target').slugify('#slug-source');

  $('.tags').tokenfield();

  $("body").hover(function() {
      var profilePic = $("input[name='image']").val();
      if(profilePic)
          $('#profile_view').html("<img class='thumbnail img-responsive mb-10' src='" + profilePic +"'/>");
  });
})

</script>
@endsection
