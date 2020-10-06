@extends('admin.body')


@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('niveaux.create') }}" class="btn btn-lg btn-primary">
                <i class="ion-plus"></i> Ajouter Niveau
            </a>
        </div>

        <div class="title">
            Niveaux
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

            <div class="mt-10">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Nom d'affichage</th>
                            <th>Created</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($niveaux as $niveau)
                            <tr data-href="{{ route('niveaux.edit', $niveau->id) }}">
                                <td>{{ $niveau->name }}</td>
                                <td>{{ $niveau->display_name }}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($niveau->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End of table -->
        </div>
    </section>


@endsection
