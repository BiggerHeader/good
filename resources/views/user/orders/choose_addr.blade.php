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

                                <div class="user-address">
                                    <!--标题 -->
                                    <div class="am-cf am-padding">
                                        <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">地址管理</strong>
                                            /
                                            <small>Address&nbsp;list</small>
                                        </div>
                                    </div>
                                    <hr/>
                                    <ul class="am-avg-sm-1 am-avg-md-3 am-thumbnails">

                                        @foreach ($addresses as $item)
                                            <li class="user-addresslist {{ $item['is_default'] ? 'defaultAddr' : '' }}">
                        <span class="new-option-r default_addr" data-id="{{ $item['id'] }}">
                            <i class="am-icon-check-circle"></i>默认地址
                        </span>
                                                <p class="new-tit new-p-re">
                                                    <span class="new-txt">{{ $item['name'] }}</span>
                                                    <span class="new-txt-rd2">{{ $item['phone'] }}</span>
                                                </p>
                                                <div class="new-mu_l2a new-p-re">
                                                    <p class="new-mu_l2cw">
                                                        <span class="title">地址：</span>
                                                        <span class="province">{{ $item['province'] }}</span>省
                                                        <span class="city">{{  $item['city'] }}</span>市
                                                        <span class="dist">{{  $item['area'] }}</span>
                                                        <br>
                                                        <span class="street">{{ $item['detail_address'] }}</span></p>
                                                </div>
                                                <div class="new-addr-btn">
                                                    <a href="{{ url("/user/addresses/{$item['id']}/edit") }}"><i
                                                                class="am-icon-edit"></i>编辑</a>
                                                    <span class="new-addr-bar">|</span>
                                                    <a href="javascript:;" data-id="{{ $item['id'] }}"
                                                       class="delete_address">
                                                        <i class="am-icon-trash"></i>删除
                                                    </a>
                                                </div>
                                            </li>
                                        @endforeach


                                    </ul>
                                    <div class="clear"></div>
                                </div>

                                <form class="mb-30" method="post" action="{{ url('/user/orders/') }}">
                                    {{ csrf_field() }}
                                    <div class="t-right">
                                        <!-- Checkout Area -->
                                        <section class="section checkout-area panel prl-30 pt-20 pb-40">
                                            <h2 class="h3 mb-20 h-title">支付</h2>
                                            {{--@if (session()->has('status'))
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    {{ session('status') }}
                                                </div>
                                            @endif--}}


                                            {{-- <form class="mb-30" method="post" action="{{ url('/user/orders/') }}">
                                                 {{ csrf_field() }}

                                                 <div class="row">

                                                     @if ($errors->has('address_id'))
                                                         <div class="alert alert-danger" role="alert">
                                                             <button type="button" class="close" data-dismiss="alert"
                                                                     aria-label="Close"><span
                                                                         aria-hidden="true">&times;</span></button>
                                                             {{ $errors->first('address_id') }}
                                                         </div>
                                                     @endif
                                                     <div class="col-md-4">
                                                         <div class="form-group">
                                                             <label>选择收货地址</label>
                                                             <select class="form-control" name="address_id">
                                                                 <option value="">请选择收货地址</option>
                                                                 @if (Auth::check())
                                                                     @foreach (Auth::user()->addresses as $address)
                                                                         <option value="{{ $address->id }}">{{ $address->name }}
                                                                             /{{ $address->phone }}</option>
                                                                     @endforeach
                                                                 @endif
                                                             </select>
                                                         </div>
                                                     </div>
                                                 </div>

                                                 @auth
                                                     <button type="submit" class="btn btn-lg btn-rounded mr-10">下单</button>
                                                 @endauth
                                                 @guest
                                                     <a href="{{ url('login') }}?redirect_url={{ url()->current() }}"
                                                        class="btn btn-lg btn-rounded mr-10">下单</a>
                                                 @endguest
                                             </form>--}}

                                            <div class="row">
                                                <div class="checkbox pull-left">
                                                    <label>
                                                        <input type="checkbox" value="">
                                                        全选
                                                    </label>
                                                </div>
                                                <span>已选择商品
                                                    <span class="cars_count">0</span>
                                                    件
                                                </span>
                                                <span>
                                                    合计
                                                    <span class="cars_price">0</span>
                                                    ￥
                                                </span>
                                                @auth
                                                <button type="submit" class="btn btn-lg btn-rounded mr-10">下单</button>
                                                @endauth
                                                @guest
                                                <a href="{{ url('login') }}?redirect_url={{ url()->current() }}"
                                                   class="btn btn-lg btn-rounded mr-10">下单</a>
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