@extends('admin.body')

@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('coupons.index') }}" class="btn btn-lg btn-teal">
                <i class="ion-reply"></i> Cancel
            </a>
        </div>

        <div class="title">
            New Coupon
        </div>
    </div>

    <section class="mt-20">
        <div class="container-fluid">
            @include('errors.list')

            <form class="_form" action="{{ route('coupons.index') }}" method="post">
                {{ csrf_field() }}

                {{-- Left side  --}}
                <div class="row">
                    <div class="col-sm-8">
                        <div class="block">
                            <div class="block-content">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Coupon</label>
                                            <input type="text" name="name" value="{{ old('name') }}"
                                            required
                                            placeholder="Coupon name"
                                            class="form-control input-lg">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Value</label>
                                            <input type="text" name="value" value="{{ old('value')}}"
                                            required
                                            placeholder="Coupon value"
                                            class="form-control input-lg">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Type of value</label>
                                            <select class="form-control input-lg" name="type">
                                                <option value="percentage">Percentage Off</option>
                                                <option value="dollar">AUD Off</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Minimum days</label>
                                            <input type="text" id="minDays" name="min_days" value="{{ old('min_days')}}"
                                            placeholder="minimum days"
                                            class="form-control input-lg">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Maximum days</label>
                                            <input type="text" id="maxDays" name="max_days" value="{{ old('max_days')}}"
                                            placeholder="maximum days"
                                            class="form-control input-lg">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="text" name="start" value="{{ old('start')}}"
                                            placeholder="Start date"
                                            class="form-control input-lg datepicker">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Expiry Date</label>
                                            <input type="text" name="expiry" value="{{ old('expiry')}}"
                                            required
                                            placeholder="Expiry date"
                                            class="form-control input-lg datepicker">
                                        </div>
                                    </div>
                                </div>
                                {{-- End of row  --}}


                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        {!! Form::label('age', 'Age') !!}

                                        <select class="form-control input-lg" name="age_id">
                                            <option value="">Select Age</option>
                                            @foreach ($ages as $age)
                                                <option value="{{ $age->id}}"
                                                    {{ old('age_id') == $age->id ? 'selected' : ''}}>
                                                    {{ $age->min.' - '.$age->max }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        {!! Form::label('location', 'Location') !!}

                                        <select class="form-control input-lg" name="location_id">
                                            <option value="">Select Location</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id}}"
                                                    {{ old('location_id') == $location->id ? 'selected' : ''}}>
                                                    {{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Maximum number of use</label>
                                            <input type="text" name="max_use" value="{{ old('max_use')}}"
                                            required
                                            placeholder="Max use"
                                            class="form-control input-lg">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        {!! Form::label('models', 'Models') !!}
                                        <div class="">
                                            <select class="js-example-basic-multiple form-control input-lg" name="models[]" multiple="multiple">
                                                <option value="">Select Models</option>
                                                @foreach ($models as $model)
                                                    <option value="{{ $model->id}}"> {{ $model->make->name.' '.$model->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End of col 9 --}}


                    <div class="col-sm-4">
                        <div class="block">
                            <div class="block-content">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control input-lg" name="status">
                                        <option value="1">Valid</option>
                                        <option value="0">Invalid</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-20">
                            <button type="submit" name="submit" class="btn btn-lg btn-wise btn-block">
                                <i class="ion-checkmark"></i> Save Coupon
                            </button>
                        </div>
                    </div>
                    {{-- End of col 3 --}}
                </div>
            </form>
        </div>
    </section>
@endsection


@section('js')
<script type="text/javascript" src="/backend/js/scripts.js"></script>
<script>
$(document).ready(function() {
    $('.datepicker').datepicker({
        autoclose: true,
        startDate: 'd',
        format: 'dd-mm-yyyy'
    })

    $('.js-example-basic-multiple').select2({
        placeholder: 'Select models'
    })
})

</script>
@endsection
