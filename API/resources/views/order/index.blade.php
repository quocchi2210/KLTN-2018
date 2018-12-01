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
                                                <td>{{$statusOrder->created_at}}</td>
                                                <td nowrap="">
                                                    {{--@if($statusItem->id == 1)--}}
                                                        {{--<button type="button"--}}
                                                                {{--data-id="{{$statusOrder->id}}"--}}
                                                                {{--class="btn btn-outline-primary btn-sm btn-edit-order"--}}
                                                                {{--data-url="{{domain_route('bussiness.admin.orders.edit',['order' => $statusOrder->id])}}">--}}
                                                            {{--<i class="fa fa-pencil"></i>--}}
                                                        {{--</button>--}}
                                                        {{--<button type="button"--}}
                                                                {{--data-id="{{$statusOrder->id}}"--}}
                                                                {{--class="btn btn-outline-danger btn-sm btn-delete-order"--}}
                                                                {{--data-url="{{domain_route('bussiness.admin.orders.edit',['order' => $statusOrder->id])}}">--}}
                                                            {{--<i class="fa fa-trash"></i>--}}
                                                        {{--</button>--}}
                                                    {{--@endif--}}
                                                    <button type="button"
                                                            data-id="{{$statusOrder->id}}"
                                                            class="btn btn-outline-info btn-sm btn-info-order"
                                                            data-url="{{route('orders.show',['order' => $statusOrder->id])}}">
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
@endsection