@extends('admin.body')

@section('head')
    <link rel="stylesheet" type="text/css" href="/backend/fancybox/jquery.fancybox.css" media="screen" />
@endsection

@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('stagiaires.index') }}" class="btn btn-lg btn-teal">
                <i class="ion-reply"></i> Cancel
            </a>
        </div>

        <div class="title">
            Editer un étudiant
        </div>
    </div>
<section class="container-fluid mt-20">
      {!! Form::model($etudiant, ['method' => 'PATCH', 'route' => ['stagiaires.update', $etudiant->number], 'class' => '_form' ]) !!}

              @include('errors.list')
              {{ csrf_field() }}

              <div class="block">
                  <div class="block-content form">

                      <div class="row mt-20">
                            <div class="col-sm-8">
                              <div class="row">
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label>Prénom(s)</label>
                                          <input type="text" name="firstname" class="form-control input-lg" value="{{ $etudiant->firstname }}" required>
                                      </div>
                                  </div>

                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label>Nom(s)</label>
                                          <input type="text" name="lastname" class="form-control input-lg" value="{{ $etudiant->lastname }}">
                                      </div>
                                  </div>

                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label>Email</label>
                                          <input type="email" name="email" class="form-control input-lg" value="{{ $etudiant->email }}" required>
                                      </div>
                                  </div>

                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label>Téléphone</label>
                                          <input type="text" name="phone" class="form-control input-lg" value="{{ $etudiant->phone }}">
                                      </div>
                                  </div>

                                  <div class="col-sm-12">
                                      <div class="form-group">
                                          <label>Niveau</label>
                                          <div class="form-select grey">
                                              <select class="form-control input-lg" name="niveau_id">
                                                  @foreach($niveaux as $item)
                                                    <option value="{{ $item->id }}" {{ $etudiant->niveau_id == $item->id ? 'selected' : ''}}>
                                                      {{ $item->display_name }}
                                                    </option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                  </div>

                              </div>
                          </div>

                          <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="form-select grey">
                                        <select name="is_active" class="form-control input-lg">
                                            <option value="0" {{ $etudiant->is_active == 0 ? 'selected' : ''}}>Inactivé</option>
                                            <option value="1" {{ $etudiant->is_active == 1 ? 'selected' : ''}}>Activé</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Date de naissance</label>
                                    <input type="date" name="dob" class="form-control input-lg date" value="{{ $etudiant->dob }}">
                                </div>

                                <hr>
                                <div class="form-group text-right mb-20">
                                    <button type="submit" class="btn btn-lg btn-primary">
                                        <i class="ion-checkmark"></i> Enregistrer
                                    </button>
                                </div>
                          </div>
                      </div>


                  </div>
              </div>
      {!! Form::close() !!}

        @if (Auth::user()->role->name === 'admin')
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
        @endif
   </section>

   @include('admin.modals.confirm', [
       'route'    => 'stagiaires.destroy',
       'method'   => 'delete',
       'resource' => $etudiant,
       'confirm'  => 'Oui, je supprime',
       'message'  => 'Voulez-vous de façon permanente supprimer '. $etudiant->name .' ?'
   ])
@endsection

@section('js')
  @include('admin.includes.scripts')
@endsection
