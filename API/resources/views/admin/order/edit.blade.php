



<div class="modal fade" id="ModalEditOrderAdmin"
     tabindex="-1" role="dialog"
     aria-labelledby="modalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"
                    id="modalLabel">{{$order->billOfLading}}</h4>
                <button type="button" class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => route('admin.orders.update',['id' => $order->idOrder]) , 'method' => 'PUT')) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('order-status', 'Status') !!}
                            {!! Form::select('Status', $status, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('order-deliver', 'Deliver') !!}
                            {!! Form::select('Deliver', $deliver, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-default pull-right"
                                data-dismiss="modal"
                                style="margin-left: 5px">Cancel
                        </button>
                        {!! Form::submit('Save', ['class' => 'btn btn-primary btn-submit']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>