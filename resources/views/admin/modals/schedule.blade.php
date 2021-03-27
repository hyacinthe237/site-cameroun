{{-- New project modal  --}}
<div class="modal fade" tabindex="-1" role="dialog" id="scheduleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Scheduled Unavailability</h4>
            </div>
            <div class="modal-body">
                {!! Form::open([ 'method'  => $method ? $method : 'delete', 'route' => [ $route, $resource->id ], 'class' => '_form' ]) !!}

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="text" name="pickup_date" value="{{ old('pickup_date')}}"
                                    placeholder="Started Date" required
                                    autocomplete="off"
                                    class="form-control input-lg datepicker"
                                >
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Start Time</label>
                                <select class="form-control input-lg" name="pickup_time">
                                    @foreach ($times as $time)
                                        <option value="{{$time->value}}">{{ $time->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="text" name="return_date" value="{{ old('return_date')}}"
                                    required placeholder="Ended Date"
                                    autocomplete="off"
                                    class="form-control input-lg datepicker"
                                >
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>End time</label>
                                <select class="form-control input-lg" name="return_time">
                                    @foreach ($times as $time)
                                        <option value="{{$time->value}}">{{ $time->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="mt-20 pb-10 text-right">
                        <a class="btn btn-teal mr-10 btn-lg" data-dismiss="modal">
                            <i class="ion-reply "></i>
                            @lang('Cancel')
                        </a>

                        <button type="submit" class="btn btn-dark btn-lg">
                            <i class="ion-checkmark"></i>
                            {{ isset($confirm) ? $confirm : 'Confirm' }}
                        </button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
