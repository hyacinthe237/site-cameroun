{{-- New project modal  --}}
<div class="modal fade" tabindex="-1" role="dialog" id="confirmModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                {!! Form::open([ 'method'  => $method ? $method : 'delete', 'route' => [ $route, $resource->id ] ]) !!}

                    <h4>Confirmation</h4>

                    <h5 class="mt-20">{{ $message }}</h5>


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
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
