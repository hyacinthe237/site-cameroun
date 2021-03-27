{{-- New project modal  --}}
<div class="modal fade" tabindex="-1" role="dialog" id="authCaptureModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                {!! Form::open([ 'class' => '_form', 'method'  => $method ? $method : 'delete', 'route' => [ $route, $resource->id ] ]) !!}

                    <h4 class="bold">Capture Auth</h4>

                    <div class="row mt-20">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label>Payment to capture from</label>
                                <select class="form-control input-lg" name="source" required>
                                    <option value="">Select auth to capture</option>
                                    @foreach($payments as $p)
                                        @if ($p->type === 'authorization')
                                            <option value="{{ $p->source }}">
                                                {{ date('d/m/Y', strtotime($p->date)) }} - {{ $p->amount_in_dollars }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Amount to capture</label>
                                <input type="text" name="amount"
                                    class="form-control input-lg"
                                    placeholder="99.99"
                                    required
                                    value="">
                            </div>
                        </div>
                    </div>



                    <div class="mt-20 pb-10">
                        <a class="btn btn-teal mr-10 btn-lg" data-dismiss="modal">
                            <i class="ion-close"></i>
                            @lang('Close')
                        </a>

                        <button type="submit" class="btn btn-dark btn-lg pull-right">
                            <i class="ion-checkmark"></i>
                            Capture Auth
                        </button>
                    </div>
                {!! Form::close() !!}


                @if($payments->count())
                    <div class="mt-20">
                        <h5 class="bold">Auth Payments</h5>

                        <table class="table">
                            <tbody>
                                @foreach($payments as $p)
                                    @if ($p->type === 'authorization')
                                        <tr>
                                            <td>{{ $p->date }}</td>
                                            <td>{{ $p->amount_in_dollars }}</td>
                                            <td>{{ $p->status }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
