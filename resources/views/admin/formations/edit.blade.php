@extends('admin.body')

@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('formation.index') }}" class="btn btn-lg btn-teal">
                <i class="ion-reply"></i> Annuler
            </a>
        </div>

        <div class="title">
            Editer une Formation
        </div>
    </div>
    <section class="container-fluid mt-20">

        {!! Form::model($formation, ['method' => 'PUT', 'route' => ['formation.update', $formation->number], 'class' => '_form' ]) !!}

            @include('errors.list')
            {{ csrf_field() }}

            <div class="block">
            <div class="block-content form">

                <div class="row mt-20">
                      <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Titre</label>
                                    <input type="text" name="title" class="form-control input-lg" value="{{ $formation->title }}" required>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Date de début</label>
                                    <input type="date" name="start_date"  value=" {{ $formation->started }}" class="form-control input-lg datepicker" placeholder="Date de début" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-xs-6">
                                      <div class="form-group">
                                          <label>Heure</label>
                                          <select class="form-control input-lg" name="start_heure">
                                              @for($i=0; $i< 24; $i++)
                                                <?php $value = $i < 10 ? '0' . $i :$i ;?>
                                                <option value="{{ $value }}"  {{ $formation->start_hour == $value ? 'selected' : '' }}>
                                                  {{ $value }}</option>
                                              @endfor
                                          </select>
                                      </div>
                                    </div>
                                    <div class="col-xs-6">
                                      <div class="form-group">
                                          <label>Minutes</label>
                                          <select class="form-control input-lg" name="start_minutes">
                                              @for($i=0; $i< 60; $i+=5)
                                                <?php $value = $i < 10 ? '0' . $i :$i ;?>
                                                <option value="{{ $value }}"  {{ $formation->start_minute == $value ? 'selected' : '' }}>
                                                  {{ $value }}</option>
                                              @endfor
                                          </select>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Date de fin</label>
                                    <input type="date" name="end_date"  value=" {{ $formation->ended }}" class="form-control input-lg datepicker" placeholder="Date de fin">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-xs-6">
                                      <div class="form-group">
                                          <label>Heure</label>
                                          <select class="form-control input-lg" name="end_heure">
                                              @for($i=0; $i< 24; $i++)
                                                <?php $value = $i < 10 ? '0' . $i :$i ;?>
                                                <option value="{{ $value }}"  {{ $formation->end_hour == $value ? 'selected' : '' }}>
                                                  {{ $value }}</option>
                                              @endfor
                                          </select>
                                      </div>
                                    </div>
                                    <div class="col-xs-6">
                                      <div class="form-group">
                                          <label>Minutes</label>
                                          <select class="form-control input-lg" name="end_minutes">
                                              @for($i=0; $i< 60; $i+=5)
                                                <?php $value = $i < 10 ? '0' . $i :$i ;?>
                                                <option value="{{ $value }}" {{ $formation->end_minute == $value ? 'selected' : '' }}>
                                                  {{ $value }}</option>
                                              @endfor
                                          </select>
                                      </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                              <div class="form-group">
                                <label>Description</label>
                                <textarea name="description"
                                    class="form-control input-lg" rows="5" cols="80">{{ $formation->description }}</textarea>
                              </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-4">
                          <div class="form-group">
                              <label>Status</label>
                              <div class="form-select grey">
                                  <select name="is_active" class="form-control input-lg">
                                      <option value="0" {{ $formation->is_active == 0 ? 'selected' : '' }}>Inactivée</option>
                                      <option value="1" {{ $formation->is_active == 1 ? 'selected' : '' }}>Activée</option>
                                  </select>
                              </div>
                          </div>

                          <div class="form-group">
                              <label>Catégories</label>
                              <div class="form-select grey">
                                  <select name="category_id" class="form-control input-lg">
                                      <option value="">Sélectionnez une catégorie</option>
                                    @foreach($categories as $item)
                                        <option value="{{ $item->id }}" {{ $formation->category_id == $item->id ? 'selected' : '' }}>
                                          {{ $item->name }}
                                        </option>
                                    @endforeach
                                  </select>
                              </div>
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
        'route'    => 'formation.delete',
        'method'   => 'delete',
        'resource' => $formation,
        'confirm'  => 'Oui, je supprime',
        'message'  => 'Voulez-vous de façon permanente supprimer cette formation ?'
    ])
@endsection

@section('js')
    @include('admin.includes.scripts')
@endsection
