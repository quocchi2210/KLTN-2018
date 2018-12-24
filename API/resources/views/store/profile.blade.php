@extends('layouts.masters')

@section('title', 'Edit Menu')

{{--@section('content-header')--}}
{{--<h1>--}}
{{--Edit menu--}}
{{--<small>{{ $product->name}}</small>--}}
{{--</h1>--}}
{{--<ol class="breadcrumb">--}}
{{--<li><a href="{{ domain_route('business.admin.dashboard') }}"><i class="fa fa-dashboard"></i> Business</a></li>--}}
{{--<li><a href="{{ domain_route('business.admin.products.index') }}">Menu</a></li>--}}
{{--<li class="active"><a href="#">Edit Menu</a></li>--}}
{{--</ol>--}}
{{--@endsection--}}

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#store-data" aria-controls="store-data" role="tab"
                                                          data-toggle="tab">Information</a></li>
            </ul>

            <div class="tab-content">
                {!! Form::open(array('url' => route('profile.update',['store' => $store->idStore]) , 'method' => 'PUT')) !!}
                <div role="tabpanel" class="tab-pane active" id="store-data">
                    <div class="tab-content">
                        <div class="panel infolist">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        {!! Form::label('store-name', 'Store Name') !!}
                                        {!! Form::text('Store[name]',$store->nameStore,['id' => 'store-name','class' => 'form-control',])!!}
                                    </div>
                                    <div class="col-md-2">
                                        {!! Form::label('store-type', 'Store Type') !!}
                                        {!! Form::text('Store[type]',$store->typeStore,['id' => 'store-type','class' => 'form-control',])!!}
                                    </div>
                                    <div class="col-md-7">
                                        {!! Form::label('store-address', 'Store Address') !!}
                                        {!! Form::text('Store[address]',$store->addressStore,['id' => 'store-address','class' => 'form-control',])!!}
                                    </div>
                                </div>
                                </br>
                                <div class="form-group">
                                    {!! Form::label('store-description', 'Store Description') !!}
                                    {!! Form::textarea('Store[description]',$store->descriptionStore,['class'=>'form-control', 'rows' => 3, 'cols' => 40]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('home') }}" class="btn btn-default pull-right"
                   style="margin-left: 5px">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary pull-right']) !!}
                {!! Form::close() !!}
            </div>

        </div>
    </div>
@endsection

{{--@section('scripts')--}}
{{--<script>--}}
{{--$('input#active-input').on('change', function () {--}}
{{--if ($(this).is(':checked')) {--}}
{{--$('input[name="Users[is_activated]"]').val(1);--}}
{{--} else {--}}
{{--$('input[name="Users[is_activated]"]').val(0);--}}
{{--}--}}
{{--})--}}
{{--</script>--}}
{{--@endsection--}}