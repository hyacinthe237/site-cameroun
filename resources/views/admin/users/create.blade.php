@extends('admin.body')

@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('users.index') }}" class="btn btn-lg btn-teal">
                <i class="ion-reply"></i> Cancel
            </a>
        </div>

        <div class="title">
            New User
        </div>
    </div>

{!! Form::open(['method' => 'POST', 'route' => ['users.store'], 'class' => '_form' ]) !!}

    <section class="container-fluid mt-20">

        @include('errors.list')

        <div class="block">
            <div class="block-content form">

                <div class="row pb-20">
                    <div class="col-sm-4">
                        <label>Sexe</label>
                        <div class="form-select grey">
                            <select name="gender" class="form-control input-lg">
                                <option value="feminin">Féminin</option>
                                <option value="asculin">Masculin</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label>Status</label>
                        <div class="form-select grey">
                            <select name="status" class="form-control input-lg">
                                <option value="">votre choix</option>
                                <option value="pending">En cours</option>
                                <option value="active">Actif</option>
                                <option value="blocked">Blocqué</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label>Role</label>
                        <div class="form-select grey">
                            <select name="role_id" class="form-control input-lg">
                                @foreach( $roles as $role )
                                    <option value="{{ $role->id}}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>First name</label>
                            <input type="text" name="firstname" class="form-control input-lg" placeholder="User's first name" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Last name</label>
                            <input type="text" name="lastname" class="form-control input-lg" placeholder="User's last name" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control input-lg" placeholder="User's email">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" name="phone" class="form-control input-lg" required value="{{ $user->phone }}">
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control input-lg" value="{{ str_random(8) }}">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Date de naissance</label>
                            <input type="text" name="dob" class="form-control input-lg date">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <div class="text-right mr-20">
        <button type="submit" class="btn btn-lg btn-primary">
            <i class="ion-checkmark"></i> Add User
        </button>
    </div>

{!! Form::close() !!}
@endsection

@section('js')
<script type="text/javascript" src="/backend/js/scripts.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    })
})
</script>
@endsection
