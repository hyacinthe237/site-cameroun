{{-- New project modal  --}}
<div class="modal fade" tabindex="-1" role="dialog" id="authCancelModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                {!! Form::open([ 'class' => '_form', 'method'  => $method ? $method : 'delete', 'route' => [ $route, $resource->id ] ]) !!}

                    <h4 class="bold">Cancel Auth</h4>

                    <div class="row mt-20">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Auth to cancel</label>
                                <select class="form-control input-lg" name="source" required>
                                    <option value="">Select auth to cancel</option>
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
                    </div>



                    <div class="mt-20 pb-10">
                        <a class="btn btn-teal mr-10 btn-lg" data-dismiss="modal">
                            <i class="ion-close"></i>
                            @lang('Close')
                        </a>

                        <button type="submit" class="btn btn-primary btn-lg pull-right">
                            <i class="ion-checkmark"></i>
                            Cancel Auth
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
