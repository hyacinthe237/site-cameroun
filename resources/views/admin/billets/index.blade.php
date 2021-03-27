@extends('admin.body')


@section('body')
    <div class="page-heading">
        <div class="buttons">
            {{-- <a href="{{ route('phases.create') }}" class="btn btn-lg btn-primary">
                <i class="ion-plus"></i> Ajouter Phase
            </a> --}}
        </div>

        <div class="title">
            Billets
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

            {{-- <div class="container">
              <div class="row"> --}}
                <div class="col-sm-4">
                  {!! Form::open(['method' => 'POST', 'route' => ['billets.store'], 'class' => '_form' ]) !!}

                      <section class="container-fluid mt-20">
                          {{ csrf_field() }}

                          <div class="block">
                              <div class="block-content form">
                                    <div class="row mt-20">

                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label>Table</label>
                                              <div class="form-select grey">
                                                  <select name="table_id" class="form-control input-lg" required>
                                                      <option value="">Sélectionnez une table</option>
                                                      @foreach ($tables as $table)
                                                        <option value="{{ $table->id }}">{{ $table->name }}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label>Type</label>
                                              <div class="form-select grey">
                                                  <select name="type" class="form-control input-lg" required>
                                                      <option value="">Sélectionnez un type</option>
                                                      <option value="Couple">Couple</option>
                                                      <option value="Single">Single</option>
                                                  </select>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label>Civilité</label>
                                              <div class="form-select grey">
                                                  <select name="civilite" class="form-control input-lg" required>
                                                      <option value="">Sélectionnez une civilité</option>
                                                      <option value="M.">M.</option>
                                                      <option value="Mme.">Mme.</option>
                                                      <option value="M. & Mme">M. & Mme</option>
                                                  </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label>Nom de l'invité</label>
                                              <input type="text" name="name" class="form-control input-lg" placeholder="Nom: John ABEGA" required>
                                          </div>
                                      </div>
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label>Code</label>
                                              <input type="text" name="code" class="form-control input-lg" value="{{ str_random(8) }}" readonly>
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
                      </section>
                  {!! Form::close() !!}
                </div>
                <div class="col-sm-8">
                  <table class="table table-striped">
                      <thead>
                          <tr>
                              <th>Nom</th>
                              <th>Table</th>
                              <th>Code</th>
                              <th>Type</th>
                              <th>Status</th>
                          </tr>
                      </thead>

                      <tbody>
                          @foreach($billets as $billet)
                              <tr>
                                  <td><a href="{{ route('billets.edit', $billet->id) }}">{{ $billet->civilite }} {{ $billet->name }}</a></td>
                                  <td>{{ $billet->table->name }}</td>
                                  <td>{{ $billet->code }}</td>
                                  <td>{{ 'Billet ' . $billet->type }}</td>
                                  <td>{{ $billet->is_entered ? 'Déjà à table' : 'Pas à table' }}</td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                </div>
              {{-- </div>
            </div> --}}
        </div>
    </section>


@endsection
