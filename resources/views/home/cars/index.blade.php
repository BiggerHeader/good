@extends('layouts.home')

@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container">
            <div class="container">
                <div class="cart-area ptb-60">
                    <div class="container">
                        <div class="cart-wrapper">
                            <div class="cart-price">
                                <h3 class="h-title mb-30 t-uppercase">我的购物车</h3>
                                {{--订单信息 确认--}}
                                <form class="mb-30" method="post" action="{{ url('/user/orders/') }}">
                                    {{ csrf_field() }}
                                    <table id="cart_list" class="cart-list mb-30">
                                        <thead class="panel t-uppercase">
                                        <tr>
                                            <th>商品名字</th>
                                            <th>原单价</th>
                                            <th>单价</th>
                                            <th>数量</th>
                                            <th>金额</th>
                                            <th>优惠</th>
                                            <th>删除</th>
                                        </tr>
                                        </thead>
                                        <tbody id="cars_data">
                                        @inject('productPresenter', 'App\Presenters\ProductPresenter')
                                        @foreach ($cars as $car)
                                            <tr class="panel">
                                                <td style="width: 100px;">
                                                    <input type="checkbox" name="product_id[]"
                                                           value="{{$car->product->id}}">
                                                    <a href="{{ url("/home/products/{$car->product->id}") }}">
                                                        {{ $car->product->name }}
                                                    </a>
                                                </td>
                                                <td class="price_original">{{ $car->product->price_original }}</td>
                                                <td class="prices">{{ $car->product->price }}</td>
                                                <td>
                                                    <button type="button" class="reduce">-</button>
                                                    <input class="quantity-label count" type="number"
                                                           name="productid_number[{{$car->product->id}}]"
                                                           value="{{ $car->numbers }}" style="width: 20px" readonly>
                                                    <button type="button" class="add">+</button>
                                                </td>
                                                <td>
                                                    <label style="color:#ff030f;"><span
                                                                style="align-content: center;">¥</span><input
                                                                class="quantity-label single_total" type="number"
                                                                readonly
                                                                value="{{ $car->numbers * $car->product->price }}"></label>
                                                </td>
                                                <td>
                                                    <label style="color:#204dff;"><span
                                                                style="align-content: center;">¥</span><input
                                                                class="quantity-label youhui_money" type="number"
                                                                readonly
                                                                value="{{ ($car->numbers*$car->product->price_original)-($car->numbers * $car->product->price) }}"></label>
                                                </td>
                                                <td>
                                                    <button data-id="{{ $car->id }}" class="close delete_car"
                                                            type="button">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="t-right">
                                        <!-- Checkout Area -->
                                        <section class="section checkout-area panel prl-30 pt-20 pb-40">
                                            <h2 class="h3 mb-20 h-title">订单信息</h2>
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
            var price_original = parent.find('.price_original').text();
            var youhui_money = $('.youhui_money')
            var singleTotal = parent.find('.single_total');
            value.val(value.val() * 1 + 1);
            singleTotal.val(value.val() * prices);
            youhui_money.val(value.val() * price_original-value.val() * prices);
            getTotal();
        })
        reduce.on('click', function () {
            var parent = $(this).parents('.panel');
            var value = parent.find('.count');
            var prices = parent.find('.prices').text();
            var price_original = parent.find('.price_original').text();
            var singleTotal = parent.find('.single_total');
            if (value.val() <= 1) {
                value.val(1);
            } else {
                value.val(value.val() * 1 - 1);
            }
            $('.youhui_money').val(value.val() * price_original-value.val() * prices);
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