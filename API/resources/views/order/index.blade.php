@extends('layouts.masters')

@section('title', 'Orders')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Orders</h1>
        </div>
        <div class="col-md-12 text-right">
            <button type="button"
                    class="btn btn-outline-primary btn-sm btn-categories"
                    data-toggle="modal"
                    data-target="#Modal">
                Add New Order
            </button>
        </div>
    </div>
    <div class="tab-v1">
        <ul class="nav nav-pills">
            @foreach($status as $statusItem)
                <li @if($statusItem->idStatus == 1) class="active" @endif><a href="#{{$statusItem->idStatus}}"
                                                                       data-toggle="tab">{{$statusItem->statusName}}</a></li>
            @endforeach
        </ul>

        <div class="tab-content">
            @foreach($status as $statusItem)
                <div role="tabpanel" class="tab-pane {{$statusItem->idStatus == 1 ? 'active' : ''}}"
                     id="{{ $statusItem->idStatus}}">
                    <div class="row">
                        <div class="col-md-12">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card p-3">
                                <div class="table-responsive-dm">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th scope="col">Name Receiver</th>
                                            <th scope="col">Receiver Phone Number</th>
                                            <th scope="col">Bill Of Lading</th>
                                            <th scope="col">Order Address</th>
                                            <th scope="col">Total Money</th>
                                            <th scope="col">Date Order</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($statusItem->order as $key => $statusOrder)
                                            <tr>
                                                <td scope="row">{{$key + 1}}</td>
                                                <td>{{$statusOrder->nameReceiver}}</td>
                                                <td>{{$statusOrder->phoneReceiver}}</td>
                                                <td>{{$statusOrder->billOfLading}}</td>
                                                <td>{{$statusOrder->addressReceiver}}</td>
                                                <td>{{number_format($statusOrder->totalMoney)}} VND</td>
                                                <td>{{$statusOrder->created_at}}</td>
                                                <td nowrap="">
                                                    @if($statusItem->idStatus == 1)
                                                        <button type="button"
                                                                data-id="{{$statusOrder->idOrder}}"
                                                                class="btn btn-outline-primary btn-sm btn-edit-order"
                                                                data-url="{{route('orders.edit',['order' => $statusOrder->idOrder])}}">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>
                                                        <button type="button"
                                                                data-id="{{$statusOrder->idOrder}}"
                                                                class="btn btn-outline-danger btn-sm btn-delete-order"
                                                                data-url="{{route('orders.edit',['order' => $statusOrder->idOrder])}}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endif
                                                    <button type="button"
                                                            data-id="{{$statusOrder->idOrder}}"
                                                            class="btn btn-outline-info btn-sm btn-info-order"
                                                            data-url="{{route('orders.show',['order' => $statusOrder->idOrder])}}">
                                                        <i class="fa fa-info-circle"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="text-center">
                                                <td colspan="5">No orders created</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <!--Modal add new-->
    <div class="modal fade modal-add" id="Modal"
         tabindex="-1" role="dialog"
         aria-labelledby="favoritesModalLabel" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"
                        id="favoritesModalLabel">Order</h4>
                    <button type="button" class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                {!! Form::open(['url' => route('orders.store'),'method' => 'POST']) !!}
                <div class="modal-body">
                    <div class="container col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('sender-name', 'Sender Name') !!}
                                    {!! Form::text(
                                        'sender[name]',
                                        old('sender[name]'),
                                        [
                                            'id' => 'sender-name',
                                            'class' => 'form-control',
                                            'required autofocus'
                                        ]
                                        )
                                    !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('sender-phone', 'Sender Phone') !!}
                                    {!! Form::text(
                                        'sender[phone]',
                                        old('sender[phone]'),
                                        [
                                            'id' => 'sender-name',
                                            'class' => 'form-control',
                                            'required autofocus'
                                        ]
                                        )
                                    !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('sender-address', 'Sender Address') !!}
                                    {!! Form::text(
                                        'sender[address]',
                                        old('sender[address]'),
                                        [
                                            'id' => 'sender-name',
                                            'class' => 'form-control',
                                            'required autofocus'
                                        ]
                                        )
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('receiver-name', 'Receiver Name') !!}
                                    {!! Form::text(
                                        'receiver[name]',
                                        old('receiver[name]'),
                                        [
                                            'id' => 'receiver-name',
                                            'class' => 'form-control',
                                            'required autofocus'
                                        ]
                                        )
                                    !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('receiver-phone', 'Receiver Phone') !!}
                                    {!! Form::text(
                                        'receiver[phone]',
                                        old('receiver[phone]'),
                                        [
                                            'id' => 'receiver-name',
                                            'class' => 'form-control',
                                            'required autofocus'
                                        ]
                                        )
                                    !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('receiver-address', 'Receiver Address') !!}
                                    {!! Form::text(
                                        'receiver[address]',
                                        old('receiver[address]'),
                                        [
                                            'id' => 'receiver-name',
                                            'class' => 'form-control',
                                            'required autofocus'
                                        ]
                                        )
                                    !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('weight', 'Total Weight') !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="order[weight]">
                            <div class="input-group-addon">
                                <span class="input-group-text" id="basic-addon2">Kilogram</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('receiver-address', 'Services') !!}
                        {!! Form::select('order[serviceTypes]',$serviceTypes, null , ['class' => 'form-control service-types']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('receiver-address', 'Note') !!}
                        {!! Form::select('order[note]',$note, null , ['class' => 'form-control service-types']) !!}
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="button"
                                    class="btn btn-default"
                                    data-dismiss="modal">Close
                            </button>
                            <span class="pull-right">
                              {!! Form::submit('Save', ['class' => 'btn btn-primary btn-block']) !!}
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection