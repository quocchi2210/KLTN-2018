
<header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner"
        style="background-image: url(images/img_bg_2.jpg)">
    <div class="overlay"></div>
    <div class="gtco-container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0 text-left">
                <div class="row row-mt-15em">
                    <div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
                        <h1>Giải pháp vận chuyển hàng  hóa và bảo mật thông tin </h1>
                    </div>
                    <div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
                        <div class="form-wrap">
                            <div class="tab">

                                <div class="tab-content">
                                    <div class="tab-content-inner active" data-content="signup">
                                        <h3>Tra cứu đơn hàng</h3>
                                        <form action="{{route('tracking')}}" method="POST">
                                            {{ csrf_field() }}
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <label for="fullname">Mã vận đơn</label>
                                                    <input type="text" id="fullname"
                                                           name="bill_of_lading"
                                                           required autofocus
                                                           placeholder="Mã vận đơn của bạn" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <input type="submit" class="btn btn-primary btn-block"
                                                           value="Xác nhận">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>