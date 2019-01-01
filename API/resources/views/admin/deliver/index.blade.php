@extends('layouts.admin.master')

@section('title', 'Giao hàng')

@section('content-header')

    <div style="margin-bottom: 25px;" class="form-group">
        <button class="btn btn-success btn-sm pull-left" data-toggle="modal" data-target="#ModalAddDeliver">Tạo tài khoản giao hàng
        </button>
    </div>
@endsection

@section('content')
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
                                    <th scope="col">Tên</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Giới tính</th>
                                    <th scope="col">Ngày sinh</th>
                                    <th scope="col">Biển số xe</th>
                                    <th scope="col">Chi tiết</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($delivers as $deliver)
                                    <tr>
                                        <td scope="row">{{$deliver->idUser}}</td>
                                        <td>{{$deliver->fullName}}</td>
                                        <td>{{$deliver->email}}</td>
                                        <td>{{$deliver->dateOfBirth}}</td>
                                        <td>{{$deliver->gender}}</td>
                                        <td>{{$deliver->deliver->licensePlates}}</td>
                                        <td nowrap="">
                                            {{--<button type="button"--}}
                                                    {{--data-id="{{$businessBranch->id}}"--}}
                                                    {{--class="btn btn-outline-primary btn-sm btn-edit-branch"--}}
                                                    {{--data-url="{{domain_route('business.admin.branches.edit',['branch' => $businessBranch->id])}}">--}}
                                                {{--<i class="fa fa-pencil"></i>--}}
                                            {{--</button>--}}
                                            {{--<button type="button"--}}
                                                    {{--data-id="{{$businessBranch->id}}"--}}
                                                    {{--class="btn btn-danger btn-sm btn-delete-branch"--}}
                                                    {{--data-url="{{domain_route('business.admin.branches.edit',['branch' => $businessBranch->id])}}">--}}
                                                {{--<i class="fa fa-trash"></i>--}}
                                            {{--</button>--}}
                                            <button type="button"
                                                    data-id="{{$deliver->idUser}}"
                                                    class="btn btn-outline-info btn-sm btn-info-branch"
                                                    data-url="{{route('admin.delivers.edit',['branch' => $deliver->idUser])}}">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="5">Không có người giao hàng nào</td>
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
    {{--<div class="form-group pull-right">--}}
        {{--{!! $businessBranches->links() !!}--}}
    {{--</div>--}}
    <div class="modal fade modal-add" id="ModalAddDeliver"
         tabindex="-1" role="dialog"
         aria-labelledby="favoritesModalLabel" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"
                        id="favoritesModalLabel">Giao hàng mới</h4>
                    <button type="button" class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                {!! Form::open(['url' => route('admin.delivers.store'),'method' => 'POST','id'=>'addCategoryForm']) !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6">
                            {!! Form::label('', 'Tên đầy đủ:') !!}
                            {!! Form::text('Deliver[full_name]', old('Deliver[full_name]'), [
                                'class' => 'form-control',
                                'placeholder' => 'John'
                            ]) !!}
                        </div>
                        <div class="col-xs-6">
                            {!! Form::label('', 'Email') !!}
                            {!! Form::email('Deliver[email]', old('Deliver[email]'), [
                                'class' => 'form-control',
                                'placeholder' => 'john.doe@email.com'
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-default pull-right"
                            data-dismiss="modal"
                            style="margin-left: 5px">Hủy
                    </button>
                    {!! Form::submit('Lưu', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        </div>
    </div>
@endsection