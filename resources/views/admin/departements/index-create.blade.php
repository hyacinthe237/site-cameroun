@extends('admin.body')

@section('head')
    <link rel="stylesheet" type="text/css" href="/backend/fancybox/jquery.fancybox.css" media="screen" />
@endsection

@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('regions.index') }}" class="btn btn-lg btn-primary">
                <i class="ion-ios-keypad"></i> Regions
            </a>

            <a href="{{ route('communes.index') }}" class="btn btn-lg btn-success">
                <i class="ion-ios-keypad"></i> Communes
            </a>
        </div>

        <div class="title">
            Départements
        </div>
    </div>

    <section class="page page-white">
        <div class="container-fluid">
            <div class="mt-10">
                <div class="row">
                    <form class="_form" action="" method="get">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <input type="text"
                                name="keywords"
                                class="form-control input-lg"
                                value="{{ Request::get('keywords') }}"
                                placeholder="Recherche...">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-lg btn-primary btn-block">
                                Filtrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @include('errors.list')

            <div class="row">
                <div class="col-sm-6">
                  {!! Form::open(['method' => 'POST', 'route' => ['departements.store'], 'class' => '_form' ]) !!}

                      <section class="container-fluid">
                          {{ csrf_field() }}

                          <div class="block">
                              <div class="block-content form">
                                    <div class="row">
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label>Nom</label>
                                              <input type="text" id="slug-source" name="name" class="form-control input-lg" placeholder="Nom" value="{{ old('name') }}" required>
                                          </div>
                                      </div>
                                      <div class="col-sm-6">
                                          <div class="form-group">
                                              <label>Slug</label>
                                              <input type="text" id="slug-target" name="slug" readonly class="form-control input-lg" placeholder="Slug" value="{{ old('slug') }}" required>
                                          </div>
                                      </div>
                                      <div class="col-sm-6">
                                          <div class="form-group">
                                              <label>Mots cles</label>
                                              <input type="text" name="tags" readonly class="form-control input-lg tags" placeholder="Tags" value="{{ old('tags') }}">
                                          </div>
                                      </div>
                                      <div class="col-sm-4">
                                          <div class="form-group">
                                              <label>Longitude</label>
                                              <input type="text" name="lon" class="form-control input-lg" placeholder="Coordonnée Longitude"  value="{{ old('lon') }}">
                                          </div>
                                      </div>
                                      <div class="col-sm-4">
                                          <div class="form-group">
                                              <label>Latitude</label>
                                              <input type="text" name="lat" class="form-control input-lg" placeholder="Coordonnée Latitude"  value="{{ old('lat') }}">
                                          </div>
                                      </div>
                                      <div class="col-sm-4">
                                          <div class="form-group">
                                              <label>Région</label>
                                              <div class="form-select grey">
                                                  <select name="region_id" class="form-control input-lg" value="{{ old('region_id') }}">
                                                      @foreach($regions as $item)
                                                          <option value="{{ $item->id}}">{{ $item->name }}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-sm-12">
                                          <h5 class="mt-20">Image</h5>

                                          <input type="hidden" class="form-control" id='profile' name='image' readonly value="{{ old('image') }}">
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
                      </section>
                  {!! Form::close() !!}
                </div>

                <div class="col-sm-6">
                  <table class="table table-striped">
                      <thead>
                          <tr>
                              <th>Nom</th>
                              <th>Created</th>
                          </tr>
                      </thead>

                      <tbody>
                          @foreach($departements as $departement)
                              <tr data-href="{{ route('departements.edit', $departement->id) }}">
                                  <td>{{ $departement->name }}</td>
                                  <td>{{ date('d/m/Y H:i', strtotime($departement->created_at)) }}</td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                  <div class="mt-10">
                    {{ $departements->links() }}
                  </div>
                </div>
            </div>
            <!-- End of table -->
        </div>
    </section>
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
