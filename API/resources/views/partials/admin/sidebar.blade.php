<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('/images/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{\Illuminate\Support\Facades\Auth::user()->decryptName()}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="{{ route('admin.orders.index') }}"><i class="fa fa-list-alt"></i> <span>Đơn hàng</span></a>
            </li>
            <li>
                <a href="{{ route('admin.stores.index') }}"><i class="fa fa-list-alt"></i> <span>Cửa hàng</span></a>
            </li>
            <li>
                <a href="{{ route('admin.delivers.index') }}"><i class="fa fa-list-alt"></i> <span>Người giao hàng</span></a>
            </li>
            {{--<li class="header">Team</li>--}}
            {{--<li class="treeview">--}}
                {{--<a href="#">--}}
                    {{--<i class="fa fa-users"></i>--}}
                    {{--<span>Users</span>--}}
                    {{--<span class="pull-right-container">--}}
              {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="{{ route('home') }}"> <i class="fa fa-users"></i> Users</a></li>--}}
                    {{--<li><a href="{{ route('home') }}"> <i class="fa fa-flag-o"></i> Roles</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>