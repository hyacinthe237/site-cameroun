@extends('admin.body')


@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('formations.download',
              [
                'category' => Request::get('category'),
                'keywords' => Request::get('keywords'),
              ])}}" class="btn btn-lg btn-success" target="_blank">
                <i class="ion-document"></i> PDF Liste
            </a>

            <a href="{{ route('formation.create') }}" class="btn btn-lg btn-primary">
                <i class="ion-plus"></i> Ajouter Formation
            </a>
        </div>

        <div class="title">
            Formations
        </div>
    </div>

    <section class="page page-white">
        <div class="container-fluid">
            <div class="mt-10">
                <div class="row">
                    <form class="_form" action="" method="get">
                      <div class="col-sm-3">
                          <div class="form-select grey">
                              <select name="is_active" class="form-control input-lg">
                                  <option value="">Tous les status</option>
                                  <option value="0" {{ Request::get('is_active') == false ? 'selected' : '' }}>Inactivée</option>
                                  <option value="1" {{ Request::get('is_active') == true ? 'selected' : '' }}>Activée</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-sm-10 mt-10">
                          <div class="form-group">
                              <input type="text"
                              name="keywords"
                              class="form-control input-lg"
                              value="{{ Request::get('keywords') }}"
                              placeholder="Recherche...">
                          </div>
                      </div>

                      <div class="col-sm-2 mt-10">
                          <button type="submit" class="btn btn-lg btn-primary btn-block">
                              Filtrer
                          </button>
                      </div>
                    </form>
                </div>
            </div>

            @include('errors.list')

            <div class="mt-10">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="bold td-40">Titre</th>
                            <th class="td-5">Status</th>
                            <th class="td-10">Catégorie</th>
                            <th class="td-10">Nbre. Etudiants</th>
                            <th class="td-10">Nbre. Formateurs</th>
                            <th class="td-15">Début</th>
                            <th class="td-15">Fin</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($formations as $formation)
                            <tr data-href="{{ route('formation.edit', $formation->number) }}">
                                <td class="bold td-40">{{ $formation->title }}</td>
                                <td class="td-5">{{ $formation->is_active ? 'Actif' : 'Non actif' }}</td>
                                <td class="td-10">{{ $formation->category ? $formation->category->name : '---' }}</td>
                                <td class="td-10">{{ count($formation->etudiants) }}</td>
                                <td class="td-10">{{ count($formation->formateurs) }}</td>
                                <td class="td-15">{{ date('d/m/Y H:i', strtotime($formation->start_date)) }}</td>
                                <td class="td-15">{{ date('d/m/Y H:i', strtotime($formation->end_date)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                 </table>
                 {{ $formations->links() }}
            </div>
            <!-- End of table *123*10*99#. -->
        </div>
    </section>
@endsection

@section('js')
    @include('admin.includes.scripts')
@endsection
