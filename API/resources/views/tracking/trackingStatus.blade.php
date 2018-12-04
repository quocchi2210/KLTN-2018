@include("layouts.head")
@include("layouts.elements.nav")

<div id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url(images/img_bg_2.jpg)">
    <div class="container">
            <div class="row top25 inboxMain">
                <div class="row text-center alert alert-info">
                    <div class="col-md-4"><h3>Order No: {{$bill}}</h3></div>
                    <div class="col-md-4"><h3>Customer: {{$nameReceiver}}</h3></div>
                    <div class="col-md-4"><h3> Status: {{$status}}</h3></div>
                </div>

                @if($status=="Pending")
                @include('tracking.steps.pending')

                @elseif($status=="Confirm")
                @include('tracking.steps.confirm')


                @elseif($status->status=="Pickup")
                @include('tracking.steps.pickup')


                @elseif($status->status=="Delivery")
                @include('tracking.steps.delivery')

                @elseif($status->status=="Done")
                @include('tracking.steps.done')

                @elseif($status->status=="Cancelled")

                <h1 align="center">your order cancelled by admin</h1>

                @endif

            </div>
    </div>
</div>