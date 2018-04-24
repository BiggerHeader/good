@extends('layouts.home')
@section('style')
    <link href="{{ asset('assets/user/css/addstyle.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container">
            <div class="container">
                <div class="cart-area ptb-60">
                    <div class="container">
                        <div class="cart-wrapper">
                            <div class="cart-price">
                                <form class="mb-30" method="post" action="{{ url('/user/submit/address') }}">
                                    {{csrf_field()}}
                                    <div class="user-address">
                                        <!--标题 -->
                                        <div class="am-cf am-padding">
                                            <div class="am-fl am-cf"><strong
                                                        class="am-text-danger am-text-lg">地址管理</strong>
                                                /
                                                <small>地址列表</small>
                                            </div>
                                        </div>
                                        <hr/>
                                        <ul class="am-avg-sm-1 am-avg-md-3 am-thumbnails">
                                            @foreach ($addresses as $item)
                                                <li>
                                                    <input type="hidden" name="id" value="{{$data['id']}}">
                                                    <p class="new-tit new-p-re">
                                                        <span class="new-txt">{{ $item['name'] }}</span>
                                                        <span class="new-txt-rd2">{{ $item['phone'] }}</span>
                                                        <input type="radio" value="{{$item['id']}}"
                                                               name="address_id" {{ $item['is_default'] ? 'checked' : '' }} >
                                                    </p>
                                                    <div class="new-mu_l2a new-p-re">
                                                        <p class="new-mu_l2cw">
                                                            <span class="title">地址：</span>
                                                            <span class="province">{{ $item['province'] }}</span>省
                                                            <span class="city">{{  $item['city'] }}</span>市
                                                            <span class="dist">{{  $item['area'] }}</span>
                                                            <br>
                                                            <span class="street">{{ $item['detail_address'] }}</span>
                                                        </p>
                                                    </div>
                                                </li>
                                            @endforeach


                                        </ul>
                                        <div class="clear"></div>
                                    </div>
                                    {{ csrf_field() }}
                                    <div class="t-right">
                                        <!-- Checkout Area -->
                                        <section class="section checkout-area panel prl-30 pt-20 pb-40">
                                            <h2 class="h3 mb-20 h-title">支付</h2>
                                            <div class="row">
                                                <span>
                                                    合计
                                                    <span class="cars_price">{{$data['total_money']}}</span>
                                                    ￥
                                                </span>
                                                @auth
                                                <button type="submit" class="btn btn-lg btn-rounded mr-10">支付</button>
                                                @endauth
                                                @guest
                                                <a href="{{ url('login') }}?redirect_url={{ url()->current() }}"
                                                   class="btn btn-lg btn-rounded mr-10">支付</a>
                                                @endguest
                                            </div>
                                        </section>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script src="{{ asset('assets/user/layer/2.4/layer.js') }}"></script>
    <script>
        var token = '{{csrf_token()}}';
        var cars_url = "{{ url("/home/cars") }}/";
        $('.delete_car').click(function () {
            var that = $(this);
            var id = that.data('id');
            var _url = cars_url + id;
            $.post(_url, {_token: token, _method: 'DELETE'}, function (res) {
                if (res.code == 302) {
                    localStorage.removeItem(id);
                }
                that.parent().parent().remove();
                getTotal();
            });
        });

        function getTotal() {
            var total = 0;
            var checkBox = $('#cars_data .panel input:checked');
            $('.cars_count').text(checkBox.length);
            checkBox.each(function () {
                var panel = $(this).parents('.panel');
                var price = panel.find('.prices').text();
                var numbers = panel.find('.count').val();
                total += price * numbers;
            });
            $('.cars_price').text(total);
        }
    </script>

    <script>
        var reduce = $('.reduce');
        var add = $('.add');
        add.on('click', function () {
            var parent = $(this).parents('.panel');
            var value = parent.find('.count');
            var prices = parent.find('.prices').text();
            var singleTotal = parent.find('.single_total');
            value.val(value.val() * 1 + 1);
            singleTotal.val(value.val() * prices);
            getTotal();
        })
        reduce.on('click', function () {
            var parent = $(this).parents('.panel');
            var value = parent.find('.count');
            var prices = parent.find('.prices').text();
            var singleTotal = parent.find('.single_total');
            if (value.val() <= 1) {
                value.val(1);
            } else {
                value.val(value.val() * 1 - 1);
            }
            singleTotal.val(value.val() * prices);
            getTotal();
        })
        $('#cars_data .panel input[type="checkbox"]').on('change', function () {
            if ($('#cars_data .panel input[type="checkbox"]').length === $('#cars_data .panel input:checked').length) {
                $('.pull-left input').prop('checked', true);
            } else {
                $('.pull-left input').prop('checked', false);
            }
            getTotal();
        })
        $('.pull-left input').on('change', function () {
            var value = $(this).prop('checked');
            $('#cars_data .panel input[type="checkbox"]').prop('checked', value);
            getTotal();
        });
    </script>
@endsection