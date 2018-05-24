@extends('layouts.home')


@section('main')
    <div id="mainContent" class="main-content">
        <div class="page-container ptb-10">
            <div class="container">
                <div class="section deals-header-area ptb-30">
                    <div class="row row-tb-20">
                        <div class="col-xs-12 col-md-4 col-lg-3">
                            <aside>
                                <ul class="nav-coupon-category panel">
                                    @foreach ($categories as $category)
                                        <li>
                                            <a href='{{ url("/home/categories/{$category['id']}") }}'>
                                                <i class="fa fa-product-hunt"></i>{{ $category['name'] }}
                                                <span>{{ $category['count'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="all-cat">
                                        <a class="font-14" href="{{ url('/home/categories') }}">查看所有分类</a>
                                    </li>
                                </ul>
                            </aside>
                        </div>


                        <div class="col-xs-12 col-md-8 col-lg-9">
                            <div class="header-deals-slider owl-slider" data-loop="true" data-autoplay="true"
                                 data-autoplay-timeout="10000" data-smart-speed="1000" data-nav-speed="false"
                                 data-nav="true" data-xxs-items="1" data-xxs-nav="true" data-xs-items="1"
                                 data-xs-nav="true" data-sm-items="1" data-sm-nav="true" data-md-items="1"
                                 data-md-nav="true" data-lg-items="1" data-lg-nav="true">
                                @foreach ($hotProducts as $hotProduct)
                                    <div class="deal-single panel item">
                                        <a href="{{ url("/home/products/{$hotProduct['id']}") }}">
                                            <figure class="deal-thumbnail embed-responsive embed-responsive-16by9"
                                                    data-bg-img="{{ starts_with($hotProduct['thumb'], 'http') ? $hotProduct['thumb'] : "/storage/{$hotProduct['thumb']}"  }}">
                                                <div class="label-discount top-10 right-10" style="width: auto;">
                                                    {{ $hotProduct['price'] }} ￥
                                                </div>
                                            </figure>
                                        </a>
                                        <div class="deal-about p-20 pos-a bottom-0 left-0">
                                            <h3 class="deal-title mb-10 ">
                                                {{ $hotProduct['name'] }}
                                            </h3>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <section class="section latest-deals-area ptb-30">
                    <header class="panel ptb-15 prl-20 pos-r mb-30">
                        <h3 class="section-title font-18">最新的商品</h3>
                        <a href="{{ url('/home/products') }}"
                           class="btn btn-o btn-xs pos-a right-10 pos-tb-center">查看所有</a>
                    </header>

                    <div class="row row-masnory row-tb-20">
                        @foreach ($latestProducts as $latestProduct)
                            <div class="col-sm-6 col-lg-4">
                                <div class="deal-single panel">
                                    <a href="{{ url("/home/products/".$latestProduct['id']) }}">
                                        <figure class="deal-thumbnail embed-responsive embed-responsive-16by9"
                                                data-bg-img="{{ starts_with($latestProduct['thumb'], 'http') ? $link : "/storage/{$latestProduct['thumb']}"  }}">

                                        </figure>
                                    </a>
                                    <div class="bg-white pt-20 pl-20 pr-15">
                                        <div class="pr-md-10">
                                          {{--  <div class="mb-10">
                                                收藏人数 <span
                                                        class="rating-count rating">{{ $latestProduct['count'] }}</span>
                                            </div>--}}
                                            <h3 class="deal-title mb-10">
                                                <a href="{{ url("/home/products/".$latestProduct['id']) }}">
                                                    {{ $latestProduct['name'] }}
                                                </a>
                                            </h3>
                                            <p class="text-muted mb-20">
                                                {!! $latestProduct['title'] !!}
                                            </p>
                                        </div>
                                        <div class="deal-price pos-r mb-15">
                                            <h3 class="price ptb-5 text-right">
                                            <span class="price-sale">
                                                {{ $latestProduct['price_original'] }}
                                            </span>
                                                ￥ {{ $latestProduct['price'] }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{ asset('assets/admin/lib/lazyload/lazyload.js') }}"></script>
    <script src="{{ asset('assets/user/layer/2.4/layer.js') }}"></script>
    <script>

        var csrf_token = "{{ csrf_token() }}";
        $('#subscribe_btn').click(function () {
            var _url = "{{ url('user/subscribe') }}";
            var _email = $('#subscribe_email').val();
            var that = $(this);
            that.attr('disabled', true);

            $.post(_url, {email: _email, _token: csrf_token}, function (res) {

                that.attr('disabled', false);

                if (res.code == 200) {
                    that.hide().next().show();
                    layer.msg(res.msg, {icon: 1});
                } else {
                    layer.msg(res.msg, {icon: 2});
                }

            });
        });

        $('#desubscribe_btn').click(function () {
            var _url = "{{ url('user/desubscribe') }}";
            var that = $(this);
            that.attr('disabled', true);

            $.post(_url, {_token: csrf_token}, function (res) {
                that.attr('disabled', false);

                if (res.code == 200) {
                    that.hide().prev().show();
                    layer.msg(res.msg, {icon: 1});
                } else {
                    layer.msg(res.msg, {icon: 2});
                }

            });
        });

        $('#login_subscribe_btn').click(function () {
            layer.confirm('请登录后再订阅', {
                btn: ['去登录', '再看看']
            }, function () {
                window.location.href = "{{ url('login') }}?redirect_dir={{ url()->current() }}";
            }, function () {
                layer.close();
            });
        });
    </script>
@endsection