@extends('admin.body')


@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('posts.create') }}" class="btn btn-lg btn-primary">
                <i class="ion-plus"></i> New Post
            </a>
        </div>

        <div class="buttons mr-50">
            <a href="{{ route('categories.index') }}" class="btn btn-lg btn-teal">
                <i class="ion-grid"></i> Categories
            </a>
        </div>

        <div class="title">
            Posts
        </div>
    </div>

    <div class="clearfix"></div>

    <section class="page page-white">
        <div class="container-fluid">

            @include('errors.list')

            <div class="mt-10">
                <div class="row">
                    <form class="_form" action="" method="get">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select class="form-control input-lg" name="status">
                                    <option value="">Select status</option>
                                    <option value="published" {{ Request::get('status') == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="unpublished" {{ Request::get('status') == 'unpublished' ? 'selected' : '' }}>Unpublished</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <input type="text"
                                        name="keywords"
                                        class="form-control input-lg"
                                        value="{{ Request::get('keywords') }}"
                                        placeholder="Page title">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-lg btn-wise btn-block">
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



            <div class="mt-10">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Published</th>
                            <th>Created</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($posts as $post)
                            <tr data-href="{{ route('posts.edit', $post->id) }}">
                                <td class="bold">{{ $post->title }}</td>
                                <td>{{ $post->category->name }}</td>
                                <td>{{ $post->status === 'published' ? 'Yes' : 'No'}}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($post->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End of table -->
        </div>
    </section>

@endsection
