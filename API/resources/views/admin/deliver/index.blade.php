@extends('layouts.admin.master')

@section('title', 'Delivers')

@section('content-header')
    <h1>
        Restaurants
    </h1>
    <div style="margin-bottom: 25px;" class="form-group">
        <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#ModalBranches">Add New
            Deliver
        </button>
    </div>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-body">
        <div class="col-md-2">
            <form action="{{route('admin.search.branch')}}" method="POST" role="search">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" name="searchBranch"
                           placeholder="Search restaurant"> <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="table-responsive-dm">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Comments</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($delivers as $deliver)
                                <tr>
                                    <td scope="row">{{$businessBranch->id}}</td>
                                    <td>{{$businessBranch->name}}</td>
                                    <td>{{$businessBranch->address}}, {{$businessBranch->ward}}
                                        , {{$businessBranch->district}}, {{$businessBranch->city}}
                                        , {{$businessBranch->country}}</td>
                                    <td>{{$businessBranch->phone_number}}</td>
                                    <td style="max-width: 330px;overflow: hidden; white-space: nowrap; text-overflow: ellipsis">{{$businessBranch->comments}}</td>
                                    <td>{{$businessBranch->created_at}}</td>
                                    <td nowrap="">
                                        <button type="button"
                                                data-id="{{$businessBranch->id}}"
                                                class="btn btn-outline-primary btn-sm btn-edit-branch"
                                                data-url="{{domain_route('business.admin.branches.edit',['branch' => $businessBranch->id])}}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button type="button"
                                                data-id="{{$businessBranch->id}}"
                                                class="btn btn-danger btn-sm btn-delete-branch"
                                                data-url="{{domain_route('business.admin.branches.edit',['branch' => $businessBranch->id])}}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <button type="button"
                                                data-id="{{$businessBranch->id}}"
                                                class="btn btn-outline-info btn-sm btn-info-branch"
                                                data-url="{{domain_route('business.admin.branches.edit',['branch' => $businessBranch->id])}}">
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
<div class="form-group pull-right">
    {!! $businessBranches->links() !!}
</div>
@endsection