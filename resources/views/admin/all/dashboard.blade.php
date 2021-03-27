@extends('admin.body')



@section('body')
<div class="page-title">
    <h3>Dashboard</h3>
</div>

<div class="dashboard">
    <div class="container-fluid">
        <div class="cards row">
            <div class="col-sm-3">
                <div class="card blue">
                    <h3>{{ 0 }}</h3>
                    <h5>Confirmed Bookings</h5>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card red">
                    <h3>{{ 0 }}</h3>
                    <h5>Collected Cars</h5>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card green">
                    <h3>{{ 0 }}</h3>
                    <h5>Returned Cars</h5>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
