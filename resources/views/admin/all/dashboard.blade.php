@extends('admin.body')

@section('body')
<div class="page-heading">
    <div class="buttons">
        <a href="{{ route('dashboard.statistiques') }}" class="btn btn-lg btn-success" target="_blank">
            <i class="ion-document"></i> Télécharger PDF
        </a>
    </div>

    <div class="title">
        Dashboard - Session {{ $data['session']->name }}

    </div>
</div>

<div class="dashboard">
    <div class="container-fluid">
        <div class="cards row mt-20">
            <div class="col-sm-12 mb-10">
                <h4 class="bold">Taux de couverture</h4>
            </div>
            <div class="col-sm-3">
                <div class="card green">
                    <h3>{{ 0 }}</h3>
                    <h5>Nombre d'inscription</h5>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card red">
                    <h3>{{ 0 }}</h3>
                    <h5>Nombre Stagiaire formés</h5>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card warning">
                    <h3>{{ 0 }}</h3>
                    <h5>Communes touchées</h5>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card dark">
                    <h3>{{ 0 }}</h3>
                    <h5>Formations exécutées</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
