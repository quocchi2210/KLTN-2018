


<!--Modal delete-->
<div class="modal fade" id="ModalDeleteOrder"
     tabindex="-1" role="dialog"
     aria-labelledby="modalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"
                    id="modalLabel">Xóa đơn hàng</h4>
                <button type="button" class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => route('orders.destroy',['order' => $order->idOrder]) , 'method' => 'DELETE')) !!}
                <h6>Bạn có muốn xóa đơn hàng này không?</h6>
                <div class="form-group">
                    <div class="modal-footer">
                        <span class="pull-right">
                                  {!! Form::submit('Có', ['class' => 'btn btn-primary btn-submit']) !!}
                            <button type="button"
                                    class="btn btn-default"
                                    data-dismiss="modal">Không</button>
                            </span>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>







<!--Modal info-->
<div class="modal fade" id="ModalInfoOrder"
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
                <div class="card p-3">
                    <div class="table-responsive-dm">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($order->detail as $orderDetail)
                                <tr>
                                    <td>{{$orderDetail->nameProduct}}</td>
                                    <td>{{number_format($orderDetail->priceProduct)}} VND</td>
                                    <td>{{$orderDetail->quantityProduct}}</td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5">No products info</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

