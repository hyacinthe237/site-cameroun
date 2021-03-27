@extends('admin.body')


@section('body')
    <div class="page-heading">
        <div class="buttons">
            {{-- <a href="{{ route('tables.create') }}" class="btn btn-lg btn-primary">
                <i class="ion-plus"></i> Ajouter une table
            </a> --}}
        </div>

        <div class="title">
            Tables
        </div>
    </div>

    <section class="page page-white">
        <div class="container-fluid">

            @include('errors.list')

            <div class="row">
              <div class="col-sm-4">
                {!! Form::open(['method' => 'POST', 'route' => ['tables.store'], 'class' => '_form' ]) !!}

                    <section class="container-fluid mt-20">
                        {{ csrf_field() }}

                        <div class="block">
                            <div class="block-content form">
                                  <div class="row mt-20">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Nom</label>
                                            <input type="text" name="name" class="form-control input-lg" placeholder="Nom" required>
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
                <div class="mt-10">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Created</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($tables as $table)
                                <tr data-href="{{ route('tables.edit', $table->id) }}">
                                    <td>{{ $table->name }}</td>
                                    <td>{{ date('d/m/Y H:i', strtotime($table->created_at)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
              </div>
            </div>


            <!-- End of table -->
        </div>
    </section>


@endsection
