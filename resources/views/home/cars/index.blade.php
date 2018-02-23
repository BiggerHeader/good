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
                                <table id="cart_list" class="cart-list mb-30">
                                    <thead class="panel t-uppercase">
                                    <tr>
                                        <th>商品名字</th>
                                        <th>单价</th>
                                        <th>数量</th>
                                        <th>金额</th>
                                        <th>删除</th>
                                    </tr>
                                    </thead>
                                    <tbody id="cars_data">
                                    @inject('productPresenter', 'App\Presenters\ProductPresenter')
                                    @foreach ($cars as $car)
                                        <tr class="panel alert">
                                            <td>
                                                <div class="media-body valign-middle">
                                                    <h6 class="title mb-15 t-uppercase">
                                                        <input type="checkbox" name="product_id[]"
                                                               value="{{$car->product->id}}">
                                                        <a href="{{ url("/home/products/{$car->product->id}") }}">
                                                            {{ $car->product->name }}
                                                        </a>
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="prices">{{ $car->product->price }}</td>
                                            <td>
                                                <button class="reduce">-</button>
                                                <input class="quantity-label count" type="number" value="{{ $car->numbers }}" style="width: 20px" readonly>
                                                <button class="add">+</button>
                                            </td>
                                            <td>
                                                <label style="color:red;">¥<input class="quantity-label" type="number"
                                                                                  value="111"></label>
                                            </td>
                                            <td>
                                                <button data-id="{{ $car->id }}" class="close delete_car" type="button">
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
                                        <h2 class="h3 mb-20 h-title">支付信息</h2>
                                        @if (session()->has('status'))
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                {{ session('status') }}
                                            </div>
                                        @endif


                                        <form class="mb-30" method="post" action="{{ url('/user/orders/') }}">
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
                                        </form>
                                    </section>
                                </div>
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
        var token= '{{csrf_token()}}';
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
            $('.prices').each(function () {
                var price = $(this).text();
                var numbers = $(this).next().find('input').val();
                total += price * numbers;
            });
            $('#cars_price').text(total);
        }
    </script>

    <script>
        var reduce =$('.reduce');
        var add =$('.add');
        var count=$('.count');
        for(var i=0; i<add.length; i++){
            (function (){
                var p = i;
                add[i].onclick = function(){
                    alert(this);
                };
            })();
        }
    </script>
@endsection