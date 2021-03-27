@extends('admin.body')


@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('categories.index') }}" class="btn btn-lg btn-teal">
                <i class="ion-reply"></i> Go Back
            </a>
        </div>

        <div class="title">
            Category
        </div>
    </div>

    <section class="page page-white">
        <div class="container-fluid">

            @include('errors.list')

            <div class="row">
                <div class="col-md-6">

                    {!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'PUT', 'class' => '_form']) !!}
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="inputPassword2" class="text-danger">Category title</label>
                            {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Type here')) !!}
                        </div>

                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}

                    {!! Form::close() !!}

                </div>

            </div>

            <div class="row">
                <div class="col-sm-6 text-left mt-50">
                    <button class="btn btn-danger" data-toggle="modal" data-target="#confirmModal">
                        Delete this category
                    </button>
                </div>
            </div>

        </div>
    </section>
    @include('admin.modals.confirm', [
            'route'    => 'categories.destroy',
            'method'   => 'POST',
            'resource' => $category,
            'confirm'  => 'Yes, delete',
            'message'  => 'Are you sure you want to permanently delete this category?'
        ])
@endsection
