{{-- New project modal  --}}
<div class="modal fade" tabindex="-1" role="dialog" id="refundModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                {!! Form::open([ 'class' => '_form', 'method'  => $method ? $method : 'delete', 'route' => [ $route, $resource->id ] ]) !!}

                    <h4 class="bold">Refund Confirmation</h4>

                    <h4 class="mt-20">{{ $message }}</h4>
                    <h5 class="bold mt-20">Booking total: {{ $booking->total_in_dollars }}</h5>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Amount to refund</label>
                                <input type="text" name="amount"
                                    class="form-control input-lg"
                                    required
                                    value="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Payment to refund from</label>
                                <select class="form-control input-lg" name="source" required>
                                    <option value="{{ $booking->stripe_charge_id }}">{{ $booking->total_in_dollars }}</option>
                                    @foreach($payments as $p)
                                        <option value="{{ $p->source }}">{{ $p->amount_in_dollars }}</option>
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

                        <button type="submit" class="btn btn-danger btn-lg">
                            <i class="ion-trash-b"></i>
                            {{ isset($confirm) ? $confirm : 'Confirm' }}
                        </button>
                    </div>
                {!! Form::close() !!}


                @if($payments->count())
                    <div class="mt-20">
                        <h5 class="bold">Payments</h5>

                        <table class="table">
                            <tbody>
                                @foreach($payments as $p)
                                    <tr>
                                        <td>{{ $p->date }}</td>
                                        <td>{{ $p->amount_in_dollars }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
