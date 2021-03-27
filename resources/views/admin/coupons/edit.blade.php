@extends('admin.body')

@section('body')
    <div class="page-heading">
        <div class="buttons">
            <a href="{{ route('coupons.index') }}" class="btn btn-lg btn-teal">
                <i class="ion-reply"></i> Go Back
            </a>
        </div>

        <div class="title">
            Edit Coupon
        </div>
    </div>

    <section class="mt-20">
        <div class="container-fluid">
            @include('errors.list')

            {!! Form::model($coupon, ['method' => 'PATCH', 'route' => ['coupons.update', $coupon->id], 'class' => '_form' ]) !!}
            {{-- Left side  --}}
            <div class="row">
                <div class="col-sm-8">
                    <div class="block">
                        <div class="block-content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Coupon</label>
                                        <input type="text" name="name" value="{{ $coupon->name }}"
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
                                        <input type="text" name="value" value="{{ $coupon->value }}"
                                        required
                                        placeholder="Coupon value"
                                        class="form-control input-lg">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Type of value</label>
                                        <select class="form-control input-lg" name="type">
                                            <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>Percentage Off</option>
                                            <option value="dollar" {{ $coupon->type == 'dollar' ? 'selected' : '' }}>AUD Off</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Minimum days</label>
                                        <input type="text" id="minDays" name="min_days" value="{{ $coupon->min_days }}"
                                        class="form-control input-lg">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Maximum days</label>
                                        <input type="text" id="maxDays" name="max_days" value="{{ $coupon->max_days }}"
                                        class="form-control input-lg">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Maximum number of use</label>
                                        <input type="text" name="max_use" value="{{ $coupon->max_use }}"
                                        required
                                        placeholder="Max use"
                                        class="form-control input-lg">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" name="start" value="{{ $coupon->start }}"
                                        required
                                        placeholder="Expiry date"
                                        class="form-control input-lg datepicker">
                                    </div>
                                </div>


                            </div>
                            {{-- End of row  --}}

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Expiry Date</label>
                                        <input type="text" name="expiry" value="{{ $coupon->expiry }}"
                                        required
                                        placeholder="Expiry date"
                                        class="form-control input-lg datepicker">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('age', 'Age') !!}

                                        <select class="form-control input-lg" name="age_id">
                                            <option value="">Select Age</option>
                                            @foreach ($ages as $age)
                                                <option value="{{ $age->id}}"
                                                    {{ $coupon->age_id == $age->id ? 'selected' : ''}}>
                                                    {{ $age->min.' - '.$age->max }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('location', 'Location') !!}

                                        <select class="form-control input-lg" name="location_id">
                                            <option value="">Select Location</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id}}"
                                                    {{ $coupon->location_id == $location->id ? 'selected' : ''}}>
                                                    {{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {!! Form::label('models', 'Models') !!}
                                        <div class="">
                                            <select multiple="multiple" name="models[]" class="js-example-basic-multiple form-control input-lg">
                                                <option value="">Select Models</option>
                                                @foreach ($models as $model)
                                                    <option value="{{ $model->id}}"
                                                        @foreach($coupon->models as $selected_model)
                                                            {{ $selected_model->id == $model->id ? 'selected' : ''}}
                                                        @endforeach
                                                        > {{ $model->make->name.' '.$model->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
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

                            <label>Status</label>
                            <div class="form-group">
                                {!! Form::select('status',
                                    ['1' => 'Valid', '0' => 'Invalid'],
                                    $coupon->status, ['class' => 'form-control input-lg']) !!}
                            </div>
                        </div>
                    </div>


                    <div class="mt-20">
                        <button type="submit" name="submit" class="btn btn-lg btn-wise btn-block">
                            <i class="ion-checkmark"></i> Update Coupon
                        </button>
                    </div>
                </div>
                {{-- End of col 3 --}}
            </div>

            {!! Form::close() !!}


            <div class="mt-10">
                <h5>Orders: {{ $orders->count() }}</h5>

                @if ($orders->count())
                    <div class="mt-10">
                        <table class="table table-striped">
                            <thead>
                                <tr class="bold">
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Status</th>
                                    <th>Total Rental</th>
                                    <th>Total With Coupon</th>
                                    <th>Booked On</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($orders as $item)
                                    <tr data-href="{{ route('orders.edit', $item->number) }}">
                                        <td class="bold">{{ $item->number }}</td>
                                        <td>{{ $item->user ? $item->user->name: '' }}</td>
                                        <td class="capitalize">{{ $item->status }}</td>
                                        <td>{{ $item->total_rental_in_dollars }}</td>
                                        <td>${{ number_format($item->getTotalRentalWithCoupon() / 100, 2) }}</td>
                                        <td>{{ date('d/m/Y H:i', strtotime($item->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <button class="btn btn-danger" data-toggle="modal" data-target="#confirmModal">
                        Delete Coupon
                    </button>
                @endif
            </div>
        </div>
    </section>

    @include('admin.modals.confirm', [
        'route'    => 'coupons.destroy',
        'method'   => 'POST',
        'resource' => $coupon,
        'confirm'  => 'Yes, delete',
        'message'  => 'Are you sure you want to permanently delete this coupon?'
    ])
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
