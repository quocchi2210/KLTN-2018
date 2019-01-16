@include("layouts.head")
@include("layouts.elements.nav")
<div id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url(images/img_bg_2.jpg)">
    <div class="overlay"></div>
    <div class="gtco-container">
        <div class="row row-mt-15em">
            <div class="col-md-7 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
                <div class="form-wrap">
                    <div class="tab">
                        <div class="tab-content">
                            <div class="tab-content-inner active" data-content="signup">
                                <h3>Tải ứng dụng</h3>
                                <a href="">
                                    <img id="getAndroid" src="images/icon-android.svg"/>
                                </a>
                                <p>Hoặc tiếp tục
                                <a href="{{route('home')}}">Tạo đơn hàng trên Website</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include("layouts.script")