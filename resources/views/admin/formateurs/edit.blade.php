@extends('admin.body')


@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('formateurs.index') }}" class="btn btn-lg btn-teal">
                <i class="ion-reply"></i> Cancel
            </a>
        </div>

        <div class="title">
            Edit Formateur
        </div>
    </div>
<section class="container-fluid mt-20">
    {!! Form::model($formateur, ['method' => 'PUT', 'route' => ['formateurs.update', $formateur->id], 'class' => '_form' ]) !!}

            @include('errors.list')
            {{ csrf_field() }}

            <div class="block">
                <div class="block-content form">
                      <div class="row mt-20">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Prénom(s)</label>
                                <input type="text" name="firstname" class="form-control input-lg" value="{{ $formateur->firstname }}" required>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Nom(s)</label>
                                <input type="text" name="lastname" class="form-control input-lg" value="{{ $formateur->lastname }}" required>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Qualification</label>
                                <input type="text" name="qualification" class="form-control input-lg" value="{{ $formateur->qualification }}" required>
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

{{-- @if (sizeOf($formateur->formations))
  <h3 class="_block-title mb-20">Formations</h3>
  <div class="block">
      <div class="block-content form">
        <div class="mt-10">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Etat</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($formateur->formations as $item)
                        <tr data-href="{{ route('formateur.edit.formation', $item->id) }}">
                            <td class="bold">{{ $item->title }}</td>
                            <td>{{ $item->is_active ? 'Active' : 'Non active' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-20">
          <form class="_form" action="{{ route('formateur.store.formation', $formateur->id) }}" method="post">
            {{ csrf_field() }}

            <div class="block">
                <div class="block-content form">

                    <div class="row mt-20">
                        <div class="col-sm-6">
                              <div class="form-group">
                                  <label>Choisissez une formation</label>
                                  <div class="form-select grey">
                                      <select name="formation_id" class="form-control input-lg">
                                        @foreach($formations as $item)
                                            <option value="{{ $item->id }}">
                                              {{ $item->title }}
                                            </option>
                                        @endforeach
                                      </select>
                                  </div>
                              </div>

                              <div class="form-group text-right mb-20">
                                  <button type="submit" class="btn btn-lg btn-primary">
                                      <i class="ion-checkmark"></i> Ajouter cette formation
                                  </button>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
          </form>
        </div>
      </div>
  </div>
@endif --}}

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
    'route'    => 'formateurs.destroy',
    'method'   => 'delete',
    'resource' => $formateur,
    'confirm'  => 'Oui, je supprime',
    'message'  => 'Voulez-vous de façon permanente supprimer ce formateur ?'
])
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('.datepicker').datepicker({
      startdate: 'd',
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHightlight: true,
    })
})
</script>
@endsection
