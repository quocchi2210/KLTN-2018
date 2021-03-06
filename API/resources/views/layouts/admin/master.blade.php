<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <base src="{{ URL::asset('/') }}" />
    <title>
        @section('title')
            {{ config('app.name') }} | Admin
        @show
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
    <link media="all" rel="stylesheet" type="text/css" href="{{ mix('backend/css/app.css') }}">
    <script src="{{ mix('js/jquery.js') }}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper" id="app">

@include('partials.admin.navbar')
<!-- =============================================== -->

@include('partials.admin.sidebar')



<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @yield('content-header')
        </section>

        <!-- Main content -->
        <section class="content">
            @include('partials.admin.notifications')
            @yield('content')
            <router-view></router-view>
        </section>
    </div>
    <!-- /.content-wrapper -->

    @include('partials.admin.footer')

    @include('partials.admin.control_sidebar')
</div>
<!-- ./wrapper -->

<script src="{{ mix('app/js/app.js') }}"></script>

<script>
    $(document).on('load',function () {
        $('.sidebar-menu').tree()
    });
</script>

</body>
</html>

