@extends('admin.body')


@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('stagiaires.download',
              [
                'formation' => Request::get('formation'),
                'keywords' => Request::get('keywords'),
              ])}}" class="btn btn-lg btn-success" target="_blank">
                <i class="ion-document"></i> PDF Liste
            </a>

            <a href="{{ route('stagiaires.create') }}" class="btn btn-lg btn-primary">
                <i class="ion-plus"></i> Ajouter
            </a>
        </div>

        <div class="title">
            Etudiants
        </div>
    </div>

    <section class="page page-white">
        <div class="container-fluid">
            <div class="mt-10">
                <div class="row">
                    <form class="_form" action="" method="get">
                        <div class="col-sm-3">
                            <div class="form-select grey">
                                <select class="form-control input-lg" name="formation">
                                    <option value="">Toutes les formations</option>
                                    @if (is_array($data['formations']) || is_object($data['formations']))
                                        @foreach($data['formations'] as $item)
                                            <option value="{{ $item->id }}"
                                              {{ Request::get('formation') == $item->id ? 'selected' : '' }}>
                                                {{ $item->title }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-select grey">
                                <select class="form-control input-lg" name="niveau">
                                    <option value="">Tous les niveaux</option>
                                    @if (is_array($data['niveaux']) || is_object($data['niveaux']))
                                        @foreach($data['niveaux'] as $item)
                                            <option value="{{ $item->id }}"
                                              {{ Request::get('niveau') == $item->id ? 'selected' : '' }}>
                                                {{ $item->display_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-10">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text"
                                        name="keywords"
                                        class="form-control input-lg"
                                        value="{{ Request::get('keywords') }}"
                                        placeholder="Rechercher nom, prénom">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-lg btn-primary btn-block">
                                        Filtrer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr>

            @include('errors.list')


            <div class="mt-10">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Etat</th>
                            <th>Niveau</th>
                            <th>Formations</th>
                            <th>Créé le</th>
                        </tr>
                    </thead>

                    <tbody>
                      @if (is_array($data['etudiants']) || is_object($data['etudiants']))
                              @foreach($data['etudiants'] as $etudiant)
                                  <tr data-href="{{ route('stagiaires.edit', $etudiant->number) }}">
                                      <td> <img src="{{ $etudiant->getImgAttribute() }}" alt="" width="70px" height="70px" class="img-round"> </td>
                                      <td class="bold">{{ $etudiant->getNameAttribute() }}</td>
                                      <td>{{ $etudiant->email }}</td>
                                      <td>{{ $etudiant->phone }}</td>
                                      <td>{{ $etudiant->is_active ? 'Actif' : 'Non Actif'}}</td>
                                      <td>{{ $etudiant->niveau->display_name }}</td>
                                      <td>{{ count($etudiant->formations) }}</td>
                                      <td>{{ date('d/m/Y H:i', strtotime($etudiant->created_at)) }}</td>
                                  </tr>
                              @endforeach
                      @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('js')
    @include('admin.includes.scripts')
@endsection
