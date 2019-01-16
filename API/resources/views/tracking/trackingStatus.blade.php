@include("layouts.head")
@include("layouts.elements.nav")

<div id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url(images/img_bg_2.jpg)">
    <div class="container">
            <div class="row top25 inboxMain">
                <div class="row text-center alert alert-info">
                    <div class="col-md-3"><h3>Mã vận đơn: {{$bill}}</h3></div>
                    <div class="col-md-3"><h3>Cửa hàng: {{$nameStore}}</h3></div>
                    <div class="col-md-3"><h3>Khách hàng: {{$nameReceiver}}</h3></div>
                    <div class="col-md-3"><h3>Tình trạng: {{$status}}</h3></div>
                </div>

                @if($status=="Chờ xác nhận")
                @include('tracking.steps.pending')

                @elseif($status=="Đã xác nhận")
                @include('tracking.steps.confirm')


                @elseif($status->status=="Đã lấy hàng")
                @include('tracking.steps.pickup')


                @elseif($status->status=="Đang giao hàng")
                @include('tracking.steps.delivery')

                @elseif($status->status=="Đã giao hàng")
                @include('tracking.steps.done')

                @elseif($status->status=="Đã hủy")

                <h1 align="center">Đơn hàng của bạn đã hủy bởi Quản trị</h1>

                @endif

            </div>
    </div>
</div>