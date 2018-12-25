


@extends('layouts.admin.master')

@section('title', 'Stores')

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
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Type Store</th>
                                    <th scope="col">Address Store</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($stores as $store)
                                    <tr>
                                        <td scope="row">{{$store->idStore}}</td>
                                        <td>{{$store->user->fullName}}</td>
                                        <td>{{$store->user->email}}</td>
                                        <td>{{$store->typeStore}}</td>
                                        <td>{{$store->addressStore}}</td>
                                        <td style="max-width: 330px;overflow: hidden; white-space: nowrap; text-overflow: ellipsis">{{$store->descriptionStore}}</td>
                                        <td nowrap="">
                                            {{--<button type="button"--}}
                                                    {{--data-id="{{$stores->id}}"--}}
                                                    {{--class="btn btn-outline-primary btn-sm btn-edit-branch"--}}
                                                    {{--data-url="{{route('business.admin.branches.edit',['branch' => $businessBranch->id])}}">--}}
                                                {{--<i class="fa fa-pencil"></i>--}}
                                            {{--</button>--}}
                                            {{--<button type="button"--}}
                                                    {{--data-id="{{$stores->id}}"--}}
                                                    {{--class="btn btn-danger btn-sm btn-delete-branch"--}}
                                                    {{--data-url="{{route('business.admin.branches.edit',['branch' => $businessBranch->id])}}">--}}
                                                {{--<i class="fa fa-trash"></i>--}}
                                            {{--</button>--}}
                                            <button type="button"
                                                    data-id="{{$store->id}}"
                                                    class="btn btn-outline-info btn-sm btn-info-branch"
                                                    data-url="{{route('admin.stores.edit',['branch' => $store->id])}}">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="5">No restaurants created</td>
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
        {{--{!! $stores->links() !!}--}}
    {{--</div>--}}
@endsection
