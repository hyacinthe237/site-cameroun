@extends('admin.body')


@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('tables.index') }}" class="btn btn-lg btn-teal">
                <i class="ion-reply"></i> Cancel
            </a>
        </div>

        <div class="title">
            Editer une table
        </div>
    </div>



    <section class="container-fluid mt-20">
      {!! Form::model($table, ['method' => 'PUT', 'route' => ['tables.update', $table->id], 'class' => '_form' ]) !!}

        @include('errors.list')
        {{ csrf_field() }}

        <div class="block">
            <div class="block-content form">
                  <div class="row mt-20">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="name" class="form-control input-lg" value="{{ $table->name }}" required>
                        </div>
                    </div>

                    <div class="col-sm-12">
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
      {{-- @if (Auth::user()->role->name === 'admin')
      <div class="row">
          <div class="col-sm-6 mb-40">
              <div class="row">
                  <div class="col-sm-6 text-left">
                      <button class="btn btn-danger" data-toggle="modal" data-target="#confirmModal">
                          Supprimer
                      </button>
                  </div>
              </div>
          </div>
      </div>
      @endif --}}
    </section>

    {{-- @include('admin.modals.confirm', [
        'route'    => 'niveaux.destroy',
        'method'   => 'delete',
        'resource' => $niveau,
        'confirm'  => 'Oui, je supprime',
        'message'  => 'Voulez-vous de façon permanente supprimer le "'. $niveau->display_name .'" ?'
    ]) --}}
@endsection
