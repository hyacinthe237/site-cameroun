@extends('admin.body')


@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('posts.index') }}" class="btn btn-lg btn-teal">
                <i class="ion-document"></i> Posts
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
                <div class="col-sm-4">
                    <form method="POST" class="_form" action="{{ route('categories.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Category title</label>
                            <input type="text"
                                name="name" class="form-control input-lg"
                                placeholder="Category title"
                            >
                        </div>

                        <div class="text-right mt-10">
                            <button type="submit" class="btn btn-primary ">Save</button>
                        </div>

                    </form>
                </div>

                <div class="col-sm-8">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Created</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach($categories as $category)
                                <tr data-href="{{ route('categories.edit', $category->id) }}">
                                    <td class="bold">{{ $category->id }}</td>
                                    <td class="bold">{{ $category->name }}</td>
                                    <td>{{ date('d/m/Y H:i', strtotime($category->created_at)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

@endsection
