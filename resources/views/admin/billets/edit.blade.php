@extends('admin.body')


@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('billets.index') }}" class="btn btn-lg btn-teal">
                <i class="ion-reply"></i> Cancel
            </a>
        </div>

        <div class="title">
            Edit Billet
        </div>
    </div>

{!! Form::model($billet, ['method' => 'PATCH', 'route' => ['billets.update', $billet->id], 'class' => '_form' ]) !!}

    <section class="container-fluid mt-20">

        @include('errors.list')
        {{ csrf_field() }}

        <div class="block">
            <div class="block-content form">
                  <div class="row mt-20">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Table</label>
                            <div class="form-select grey">
                                <select name="table_id" class="form-control input-lg" required>
                                    <option value="">Sélectionnez une table</option>
                                    @foreach ($tables as $table)
                                      <option value="{{ $table->id }}" {{ $billet->table_id == $table->id ? 'selected' : '' }}>{{ $table->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Type</label>
                            <div class="form-select grey">
                                <select name="type" class="form-control input-lg" required>
                                    <option value="">Sélectionnez un type</option>
                                    <option value="Couple" {{ $billet->type == 'Couple' ? 'selected' : '' }}>Couple</option>
                                    <option value="Single" {{ $billet->civilite == 'Single' ? 'selected' : '' }}>Single</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Civilité</label>
                            <div class="form-select grey">
                                <select name="civilite" class="form-control input-lg" required>
                                    <option value="">Sélectionnez une civilité</option>
                                    <option value="M." {{ $billet->civilite == 'M.' ? 'selected' : '' }}>M.</option>
                                    <option value="Mme." {{ $billet->civilite == 'Mme.' ? 'selected' : '' }}>Mme.</option>
                                    <option value="M. & Mme" {{ $billet->civilite == 'M. & Mme' ? 'selected' : '' }}>M. & Mme</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Nom de l'invité</label>
                            <input type="text" name="name" class="form-control input-lg" value="{{ $billet->name }}" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Code</label>
                            <input type="text" name="code" class="form-control input-lg" value="{{ $billet->code }}" readonly>
                        </div>
                    </div>

                    <div class="col-sm-4">
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
@endsection
