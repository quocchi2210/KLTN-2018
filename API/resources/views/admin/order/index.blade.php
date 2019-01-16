@extends('layouts.admin.master')

@section('title', 'Đơn hàng')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Đơn hàng</h1>
        </div>
    </div>
    <div class="tab-v1">
        <ul class="nav nav-pills">
            @foreach($status as $statusItem)
                <li @if($statusItem->idStatus == 1) class="active" @endif><a href="#{{$statusItem->idStatus}}"
                                                                             data-toggle="tab">{{$statusItem->statusName}}</a>
                </li>
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
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card p-3">
                                                <div class="table-responsive-dm">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th scope="col">Cửa hàng</th>
                                                            <th scope="col">Tên người nhận</th>
                                                            <th scope="col">Mã vận đơn</th>
                                                            <th scope="col">Địa chỉ giao hàng</th>
                                                            <th scope="col">Ngày giao hàng dự kiến</th>
                                                            <th scope="col">Tổng tiền</th>
                                                            <th scope="col">Tên người giao hàng</th>
                                                            <th scope="col">Ngày tao đơn hàng</th>
                                                            <th scope="col">Xác nhận</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @forelse($statusItem->order as $key => $statusOrder)
                                                            <tr>
                                                                <td scope="row">{{$key + 1}}</td>
                                                                <td>{{$statusOrder->store->nameStore}}</td>
                                                                <td>{{$statusOrder->nameReceiver}}</td>
                                                                <td>{{$statusOrder->billOfLading}}</td>
                                                                <td>{{$statusOrder->addressReceiver}}</td>
                                                                <td>{{$statusOrder->timeDelivery}}</td>
                                                                <td>{{number_format($statusOrder->totalMoney)}} VND</td>
                                                                @if($statusOrder->idShipper)
                                                                <td>{{$statusOrder->deliver->user->fullName}}</td>
                                                                @endif
                                                                @if(!$statusOrder->idShipper)
                                                                <td></td>
                                                                @endif
                                                                <td>{{$statusOrder->timeDelivery}}</td>
                                                                <td>{{$statusOrder->created_at}}</td>
                                                                <td nowrap="">
                                                                    {{--@if($statusItem->id == 1)--}}
                                                                    <button type="button"
                                                                            data-id="{{$statusOrder->idOrder}}"
                                                                            class="btn btn-outline-primary btn-sm btn-edit-order-admin"
                                                                            data-url="{{route('admin.orders.edit',['order' => $statusOrder->idOrder])}}">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </button>
                                                                    {{--<button type="button"--}}
                                                                    {{--data-id="{{$statusOrder->id}}"--}}
                                                                    {{--class="btn btn-outline-danger btn-sm btn-delete-order"--}}
                                                                    {{--data-url="{{domain_route('bussiness.admin.orders.edit',['order' => $statusOrder->id])}}">--}}
                                                                    {{--<i class="fa fa-trash"></i>--}}
                                                                    {{--</button>--}}
                                                                    {{--@endif--}}
                                                                    {{--<button type="button"--}}
                                                                            {{--data-id="{{$statusOrder->idOrder}}"--}}
                                                                            {{--class="btn btn-outline-info btn-sm btn-info-order"--}}
                                                                            {{--data-url="{{route('admin.orders.show',['order' => $statusOrder->idOrder])}}">--}}
                                                                        {{--<i class="fa fa-info-circle"></i>--}}
                                                                    {{--</button>--}}
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr class="text-center">
                                                                <td colspan="5">Không có đơn hàng nào</td>
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
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection