@extends('layouts.shop')


@section('main')
    <div class="listMain">
    @inject('productPresenter', 'App\Presenters\ProductPresenter')
    <!--放大镜-->

        <div class="item-inform">
            <div class="clearfixLeft" id="clearcontent">

                <div class="box">
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $(".jqzoom").imagezoom();
                            $("#thumblist li a").click(function () {
                                $(this).parents("li").addClass("tb-selected").siblings().removeClass("tb-selected");
                                $("#jqzoom").attr('src', $(this).find("img").attr("src"));
                            });
                        });
                    </script>

                    <div class="tb-booth tb-pic tb-s310">
                        <img src="{{ $productPresenter->getThumbLink($product->thumb) }}" alt="{{ $product->name }}"
                             id="jqzoom"/>
                    </div>
                    <ul class="tb-thumb" id="thumblist">
                        @foreach ($product->productImages as $key => $image)
                            <li class="{{ $key == 0 ? 'tb-selected' : '' }}">
                                <div class="tb-pic tb-s40">
                                    <a href="javascript:;">
                                        <img src="{{ $productPresenter->getThumbLink($image->link) }}">
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="clear"></div>
            </div>

            <div class="clearfixRight">

                <!--规格属性-->
                <!--名称-->
                <div class="tb-detail-hd">
                    <h1>
                        {{ $product->name }}
                    </h1>
                </div>
                <div class="tb-detail-list">
                    <!--价格-->
                    <div class="tb-detail-price">
                        <li class="price iteminfo_price">
                            <dt>促销价</dt>
                            <dd><em>¥</em><b class="sys_item_price">{{ $product->price }}</b></dd>
                        </li>
                        <li class="price iteminfo_mktprice">
                            <dt>原价</dt>
                            <dd><em>¥</em><b class="sys_item_mktprice">{{ $product->price_original }}</b></dd>
                        </li>
                        <div class="clear"></div>
                    </div>

                    <!--地址-->
                    {{-- <dl class="iteminfo_parameter freight">
                         <dt>收货地址</dt>
                         <div class="iteminfo_freprice">
                             <div class="am-form-content address">

                                 @if (Auth::check())
                                     <select data-am-selected name="address_id">
                                         @foreach (Auth::user()->addresses as $address)
                                             <option value="{{ $address->id }}">{{ $address->name }}/{{ $address->phone }}</option>
                                         @endforeach
                                     </select>
                                 @else
                                     <a style="line-height:27px;color:red;" href="{{ url('user')  }}">添加收货地址</a>
                                 @endif

                             </div>
                         </div>
                     </dl>--}}
                    <div class="clear"></div>

                    <!--销量-->
                    <ul class="tm-ind-panel">
                        <li class="tm-ind-item tm-ind-sumCount canClick">
                            <div class="tm-indcon"><span class="tm-label">累计销量</span><span
                                        class="tm-count">{{ $product->safe_count }}</span></div>
                        </li>
                        <li class="tm-ind-item tm-ind-reviewCount canClick tm-line3">
                            <div class="tm-indcon"><span class="tm-label">累计评价</span><span class="tm-count">640</span>
                            </div>
                        </li>
                    </ul>
                    <div class="clear"></div>

                    <!--各种规格-->
                    <dl class="iteminfo_parameter sys_item_specpara">
                        <dt class="theme-login">
                        <div class="cart-title">可选规格<span class="am-icon-angle-right"></span></div>
                        </dt>
                        <dd>
                            <!--操作页面-->

                            <div class="theme-popover-mask"></div>

                            <div class="theme-popover">
                                <div class="theme-span"></div>
                                <div class="theme-poptit">
                                    <a href="javascript:;" title="关闭" class="close">×</a>
                                </div>
                                <div class="theme-popbod dform">
                                    <form class="theme-signin" name="" action="" method="post">

                                        <div class="theme-signin-left">
                                            @foreach ($product->productAttributes()->get()->groupBy('attribute')->toArray() as $item => $attrs)
                                                <div class="theme-options">
                                                    <div class="cart-title">{{ $item }}</div>
                                                    <ul>
                                                        @foreach ($attrs as $key => $attr)
                                                            <li title="价格浮动 {{ $attr['markup'] }}"
                                                                class="sku-line {{ $key == 0 ? 'selected' : '' }}">{{ $attr['items'] }}
                                                                <i></i></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                            <div class="theme-options">
                                                <div class="cart-title number">数量</div>
                        <dd>
                            <input id="min" class="am-btn am-btn-default" type="button" value="-"/>
                            <input id="text_box" name="numbers" type="text" value="1" style="width:30px;"/>
                            <input id="add" class="am-btn am-btn-default" type="button" value="+"/>
                            <span id="Stock" class="tb-hidden">库存<span
                                        class="stock">{{ $product->productDetail->count }}</span>件</span>
                        </dd>

                    </dl>
                    <div class="pay">
                        <div class="pay-opt">
                            <a href="{{ url('/') }}"><span class="am-icon-home am-icon-fw">首页</span></a>
                            @auth
                            @if ($product->users()->where('user_id', \Auth::user()->id)->count() > 0)
                                <a href="javascript:;" style="display: none" id="likes_btn"><span
                                            class="am-icon-heart am-icon-fw">收藏</span></a>
                                <a href="javascript:;" id="de_likes_btn"><span
                                            class="am-icon-heart am-icon-fw">取消收藏</span></a>
                            @else
                                <a href="javascript:;" id="likes_btn"><span
                                            class="am-icon-heart am-icon-fw">收藏</span></a>
                                <a href="javascript:;" style="display: none" id="de_likes_btn"><span
                                            class="am-icon-heart am-icon-fw">取消收藏</span></a>
                            @endif
                            @endauth

                            @guest
                            <a href="javascript:;" id="likes_btn"><span class="am-icon-heart am-icon-fw">收藏</span></a>
                            @endguest

                        </div>
                        <li>
                            <div class="clearfix tb-btn" id="nowBug">
                                @auth
                                <a href="javascript:;">立即购买</a>
                                @endauth
                                @guest
                                <a href="{{ url('login') }}?redirect_url={{ url()->current() }}">立即购买</a>
                                @endguest

                            </div>
                        </li>
                        <li>
                            <div class="clearfix tb-btn tb-btn-basket">
                                <a title="加入购物车" href="javascript:;" id="addCar"><i></i>加入购物车</a>
                            </div>
                        </li>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
        <!--活动	-->
    </div>
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <div class="clear"></div>

    <!-- introduce-->

    <div class="introduce">
        <div class="browse">
            <div class="mc">
                <ul>
                    <div class="mt">
                        <h2>推荐</h2>
                    </div>

                    @foreach ($recommendProducts as $recommendProduct)
                        <li class="first">
                            <div class="p-img">
                                <a href="{{ url("/home/products/{$recommendProduct->id}") }}">
                                    <img class="media-object"
                                         src="{{ $productPresenter->getThumbLink($recommendProduct->thumb) }}"
                                         alt="{{ $recommendProduct->name }}" width="80">
                                </a>
                            </div>
                            <div class="p-name"><a href="{{ url("/home/products/{$recommendProduct->id}") }}">
                                    {{ $recommendProduct->name }}
                                </a>
                            </div>
                            <div class="p-price"><strong>
                                    ￥ {{ $recommendProduct->price }}
                                </strong></div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div class="introduceMain">
            <div class="am-tabs" data-am-tabs>
                <ul class="am-avg-sm-3 am-tabs-nav am-nav am-nav-tabs">
                    <li class="am-active">
                        <a href="#">
                            <span class="index-needs-dt-txt">宝贝详情</span></a>
                    </li>

                    <li>
                        <a href="#">

                            <span class="index-needs-dt-txt">全部评价</span></a>

                    </li>
                </ul>

                <div class="am-tabs-bd">

                    <div class="am-tab-panel am-fade am-in am-active">
                        <div class="details">
                            <div class="attr-list-hd after-market-hd">
                                <h4>商品细节</h4>
                            </div>
                            <div class="twlistNews">
                                {!! $product->productDetail->description !!}
                            </div>
                        </div>
                        <div class="clear"></div>

                    </div>

                    <div class="am-tab-panel am-fade">
                        @if(!empty($is_buy))
                            <div class="actor-new">
                                <p style="left: 0px;float: left;">
                                    <textarea rows="2" cols="50" id="comment_content"></textarea>
                                    <button type="button" class="btn" id="submit">提交</button>
                                </p>
                            </div>
                        @endif
                        <div class="clear"></div>
                        <div class="tb-r-filter-bar">
                            <ul class=" tb-taglist am-avg-sm-4">
                                评论列表
                                {{-- <li class="tb-taglist-li tb-taglist-li-current">
                                     <div class="comment-info">
                                         <span>全部评价</span>
                                         <span class="tb-tbcr-num">(32)</span>
                                     </div>
                                 </li>

                                 <li class="tb-taglist-li tb-taglist-li-1">
                                     <div class="comment-info">
                                         <span>好评</span>
                                         <span class="tb-tbcr-num">(32)</span>
                                     </div>
                                 </li>

                                 <li class="tb-taglist-li tb-taglist-li-0">
                                     <div class="comment-info">
                                         <span>中评</span>
                                         <span class="tb-tbcr-num">(32)</span>
                                     </div>
                                 </li>

                                 <li class="tb-taglist-li tb-taglist-li--1">
                                     <div class="comment-info">
                                         <span>差评</span>
                                         <span class="tb-tbcr-num">(32)</span>
                                     </div>
                                 </li>--}}
                            </ul>
                        </div>
                        <div class="clear"></div>

                        <ul id="comments" class="am-comments-list am-comments-list-flip">
                          {{--  <li class="am-comment">
                                <!-- 评论容器 -->
                                <a href="">
                                    <img class="am-comment-avatar" src="{{asset('assets/user/images/hwbn40x40.jpg')}}"/>
                                    <!-- 评论者头像 -->
                                </a>

                                <div class="am-comment-main">
                                    <!-- 评论内容容器 -->
                                    <header class="am-comment-hd">
                                        <!--<h3 class="am-comment-title">评论标题</h3>-->
                                        <div class="am-comment-meta">
                                            <!-- 评论元数据 -->
                                            <a href="#link-to-user" class="am-comment-author">b***1 (匿名)</a>
                                            <!-- 评论者 -->
                                            评论于
                                            <time datetime="">2015年11月02日 17:46</time>
                                        </div>
                                    </header>

                                    <div class="am-comment-bd">
                                        <div class="tb-rev-item " data-id="255776406962">
                                            <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                                摸起来丝滑柔软，不厚，没色差，颜色好看！买这个衣服还接到诈骗电话，我很好奇他们是怎么知道我买了这件衣服，并且还知道我的电话的！
                                            </div>
                                            <div class="tb-r-act-bar">
                                                颜色分类：柠檬黄&nbsp;&nbsp;尺码：S
                                            </div>
                                        </div>

                                    </div>
                                    <!-- 评论内容 -->
                                </div>
                            </li>--}}
                        </ul>

                        <div class="clear"></div>

                        <!--分页 -->
                        <ul class="am-pagination am-pagination-right">
                            <li class="am-disabled"><a href="#">&laquo;</a></li>
                            <div class="paginationCount">
                                <li class="am-active"><a href="#">1</a></li>
                                <li>2</li>
                                <li>3</li>
                                <li>4</li>
                                <li>5</li>
                            </div>
                            <li>&raquo;</li>
                        </ul>
                        <div class="clear"></div>

                        <div class="tb-reviewsft">
                            <div class="tb-rate-alert type-attention">购买前请查看该商品的 <a href="#" target="_blank">购物保障</a>，明确您的售后保障权益。
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="clear"></div>

            <div class="footer">
                <div class="footer-hd">
                    <p>
                        <a href="#">商城</a>
                        <b>|</b>
                        <a href="#">商城首页</a>
                        <b>|</b>
                        <a href="#">支付宝</a>
                        <b>|</b>
                        <a href="#">物流</a>
                    </p>
                </div>
                @include('common.home.footer')
            </div>
        </div>

    </div>
    </div>
    <form id="pay_form" action="{{ url('/user/pay/show') }}" method="post">
        {{ csrf_field() }}
    </form>
@endsection

@section('script')
    <script src="{{ asset('assets/user/layer/2.4/layer.js') }}"></script>
    <script src="{{ asset('js/jquery-addShopping.js') }}"></script>
    <script>
        var product_id = $('input[name=product_id]').val();
        var _url = "{{ url("/user/likes") }}/" + product_id;
        var token = "{{ csrf_token() }}";
        var likes_nums = $('#likes_count');
        var page = 1;
        var pageSize = 5;
        var pageTotal = 0;
        $('.am-pagination').on('click', 'li', function () {
            var index = $(this).index();
            if (index === 0) {
                page = 1;
            } else if ((index - 1) === pageTotal) {
                page = pageTotal;
            } else {
                page = index;
            }
            getPageContent();
        })
        getPageContent();

        function getPageContent() {
            // ajax 获取评论列表
            $.ajax({
                url: 'http://yaf.com/comment/comment/get/product_id',
                type: 'get',
                data: {product_id: product_id, page: page, pageSize: pageSize},
                dataType: "json",
                success: function (respones) {
                    if (respones.code == 10000) {
                        console.log(respones);
                        var str = '';
                        var paginationHtml = `<li class="am-disabled"><a href="javascript:;">&laquo;</a></li>`
                        pageTotal = Math.ceil(respones.count / pageSize);
                        for (let i = 0; i < pageTotal; i++) {
                            paginationHtml += `<li><a href="javascript:;">${ i + 1 }</a></li>`;
                        }
                        paginationHtml += `<li><a href="javascript:;">&raquo;</a></li>`;
                        $('.am-pagination').html(paginationHtml);
                        for (let i = 0; i < respones.list.length; i++) {
                            var item = respones.list[i]
                            str += `
                                <li class="am-comment">
                                <a href="">
                                <img class="am-comment-avatar" src="http://biyesheji.com/assets/user/images/hwbn40x40.jpg">
                                </a>
                                <div class="am-comment-main">
                                <header class="am-comment-hd">
                                <!--<h3 class="am-comment-title">评论标题</h3>-->
                                <div class="am-comment-meta">
                                <a href="#link-to-user" class="am-comment-author">${item.name}</a>
                                评论于
                                <time datetime="">${item.create_time}</time>
                                </div>
                                </header>
                                <div class="am-comment-bd">
                                <div class="tb-rev-item " data-id="255776406962">
                                <div class="J_TbcRate_ReviewContent tb-tbcr-content ">
                                ${item.content}
                                </div>
                                </div>
                                </div>
                                </div>
                                </li>
                            `;
                        }
                        console.log(str);
                        $('.am-comments-list').html(str);
                    }
                }
            });
        }
        //提交 评论 模块
        $('#submit').click(function () {
            var comment = {};
            comment.content = $('#comment_content').val();
            @if (Auth::guard()->user())
                comment.user_id = "{{ Auth::guard()->user()->id}}";
            @endif
                comment.product_id = product_id;
            if (comment.content.length > 5) {
                $.ajax({
                    url: "http://yaf.com/comment/comment/add",
                    data: JSON.stringify(comment),
                    type: 'post',
                    dataType: "json",
                    //contentType: 'application/json;charset=utf-8',
                    success: function (respones) {
                        if (respones.code == 10000) {
                            layer.msg(respones.msg);
                        } else {
                            layer.msg(respones.msg);
                        }
                    }
                });
            } else {
                layer.msg('评论数不能小于5个字符！');
            }

        })

        $('#likes_btn').click(function () {
            var that = $(this);

            $.post(_url, {_token: token}, function (res) {
                layer.msg(res.msg);

                if (res.code == 301) {
                    return;
                }

                that.hide().next().show();
                likes_nums.text(parseInt(likes_nums.text()) + 1);
            });
        });
        $('#de_likes_btn').click(function () {
            var that = $(this);

            $.post(_url, {_token: token, _method: 'DELETE'}, function (res) {
                layer.msg(res.msg);

                if (res.code == 301) {
                    return;
                }

                that.hide().prev().show();
                likes_nums.text(parseInt(likes_nums.text()) - 1);
            });
        });

        var Car = {
            addProduct: function (product_id) {

                var numbers = $("input[name=numbers]").val();
                if (!localStorage.getItem(product_id)) {
                    var product = {name: "{{ $product->name }}", numbers: numbers, price: "{{ $product->price }}"};
                } else {
                    var product = $.parseJSON(localStorage.getItem(product_id));
                    product.numbers = parseInt(product.numbers) + parseInt(numbers);
                }
                localStorage.setItem(product_id, JSON.stringify(product))
            }
        };

        var car_nums = $('#cart-number');
        $('#addCar').shoping({
            endElement: "#car_icon",
            iconCSS: "",
            iconImg: $('#jqzoom').attr('src'),
            endFunction: function (element) {

                var numbers = $("input[name=numbers]").val();
                var data = {product_id: "{{ $product->id }}", _token: token, numbers: numbers};
                var url = "{{ url('/home/cars') }}";
                $.post(url, data, function (res) {
                    console.log(res);

                    if (res.code == 304) {

                        layer.msg(res.msg, {icon: 2});
                        return;
                    }

                    if (res.code == 302) {
                        Car.addProduct(product_id);
                    }
                    layer.msg('加入购物车成功');
                    car_nums.text(parseInt(car_nums.text()) + 1);
                });
            }
        });

        $('#nowBug').click(function () {
            var _address_id = $('select[name=address_id]').val();
            var _numbers = $('input[name=numbers]').val();
            var _product_id = $('input[name=product_id]').val();


            var data = {
                address_id: _address_id,
                numbers: _numbers,
                product_id: _product_id,
                _token: "{{ csrf_token() }}"
            };
            console.log(data);
            $.post('{{ url('user/orders/single') }}', data, function (res) {
                layer.msg(res.msg);
            });

            /** v请求支付 **/
            var form = $('#pay_form');
            var input = '<input type="hidden" name="_address_id" value="' + _address_id + '">\
                        <input type="hidden" name="_product_id" value="' + _product_id + '">\
                        <input type="hidden" name="_numbers" value="' + _numbers + '">';
            form.append(input);
            form.submit();
        });
    </script>
@endsection