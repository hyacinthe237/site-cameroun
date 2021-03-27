@extends('admin.body')

@section('body')
<div class="page-heading">

    <div class="title">
        Tableau de bord

    </div>
</div>

<div class="dashboard">
    <div class="container-fluid">
        <div class="cards row mt-20">
            <div class="col-sm-4">
                <div class="card green">
                    <h3>{{ count($billets) }}</h3>
                    <h5>Nombre de billets</h5>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card red">
                    <h3>{{ count($tables) }}</h3>
                    <h5>Nombre de tables</h5>
                </div>
            </div>

            <div class="col-sm-12 mt-60">
              <div class="block">
                  <div class="block-content">

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
                    <div class="col-sm-12">
                      @include('errors.list')
                    </div>
                      <div class="">
                        <table class="table table-striped mt-40">
                            <tbody>
                                @if($billet)
                                    <tr>
                                        <td><a href="{{ route('billets.edit', $billet->id) }}">{{ $billet->civilite }} {{ $billet->name }}</a></td>
                                        <td>{{ $billet->table->name }}</td>
                                        <td>{{ $billet->code }}</td>
                                        <td>{{ 'Billet ' . $billet->type }}</td>
                                        <td>{{ $billet->is_entered ? 'Déjà à table' : 'Pas à table' }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                      </div>
                  </div>
              </div>
            </div>
        </div>


    </div>
</div>
@endsection
