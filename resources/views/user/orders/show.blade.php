@extends('layouts.user')

@section('style')
    <link href="{{ asset('assets/user/css/orstyle.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('main')
    <div class="main-wrap">

        <div class="user-orderinfo">

            <!--标题 -->
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">订单详情</strong> /
                    <small>Order&nbsp;details</small>
                </div>
            </div>
            <hr/>
            <!--进度条-->
            <div class="m-progress">
                <div class="m-progress-list">
								<span class="step-1 step">
                                   <em class="u-progress-stage-bg"></em>
                                   <i class="u-stage-icon-inner">1
                                       @if($order->status>=0)
                                           <em class="bg"
                                               style="background-image: url({{asset('assets/user/images/sprite.png')}});background-position: -103px -135px;width: 19px;height: 19px;"></em>
                                       @else
                                           <em class="bg"></em>
                                       @endif
                                   </i>
                                   <p class="stage-name">拍下商品</p>
                                </span>
                    <span class="step-2 step">
                                   <em class="u-progress-stage-bg"></em>
                                   <i class="u-stage-icon-inner">2
                                       @if($order->status>=1)
                                           <em class="bg"
                                               style="background-image: url({{asset('assets/user/images/sprite.png')}});background-position: -103px -135px;width: 19px;height: 19px;"></em>
                                       @else
                                           <em class="bg"></em>
                                       @endif
                                   </i>
                                   <p class="stage-name">卖家发货</p>
                                </span>
                    <span class="step-3 step">
                                   <em class="u-progress-stage-bg"></em>
                                   <i class="u-stage-icon-inner">3 @if($order->status>=2)
                                           <em class="bg"
                                               style="background-image: url({{asset('assets/user/images/sprite.png')}});background-position: -103px -135px;width: 19px;height: 19px;"></em>
                                       @else
                                           <em class="bg"></em>
                                       @endif
                                   </i>
                                   <p class="stage-name">确认收货</p>
                                </span>
                    <span class="step-4 step">
                                   <em class="u-progress-stage-bg"></em>
                                   <i class="u-stage-icon-inner">4
                                       @if($order->status>=3)
                                           <em class="bg"
                                               style="background-image: url({{asset('assets/user/images/sprite.png')}});background-position: -103px -135px;width: 19px;height: 19px;"></em>
                                       @else
                                           <em class="bg"></em>
                                       @endif
                                   </i>
                                   <p class="stage-name">交易完成</p>
                                </span>
                    <span class="u-progress-placeholder"></span>
                </div>
                <div class="u-progress-bar total-steps-2">
                    <div class="u-progress-bar-inner"></div>
                </div>
            </div>

            @inject('userPresenter', 'App\Presenters\UserPresenter')
            <div class="order-infoaside">
                <div class="order-logistics">
                    <a href="#">
                        <div class="icon-log">
                            <i><img src="{{ $userPresenter->getAvatarLink($order->user->avatar) }}"></i>
                        </div>
                        <div class="latest-logistics">
                            <p class="text">订单号：{{ $order->uuid }}</p>
                            <div class="time-list">
                                <span class="date">{{ $order->created_at }}</span>
                            </div>
                        </div>
                        <span class="am-icon-angle-right icon"></span>
                    </a>
                    <div class="clear"></div>
                </div>
                <div class="order-addresslist">
                    <div class="order-address">
                        <div class="icon-add">
                        </div>
                        <p class="new-tit new-p-re">
                            <span class="new-txt">{{ $order->address->name }}</span>
                            <span class="new-txt-rd2">{{ $order->address->phone }}</span>
                        </p>
                        <div class="new-mu_l2a new-p-re">
                            <p class="new-mu_l2cw">
                                <span class="title">收货地址：</span>
                                <span class="province">{{ $order->address->province }}</span>省
                                <span class="city">{{ $order->address->city }}</span>市
                                <span class="dist">{{ $order->address->area }}</span>区
                                <span class="street">{{ $order->address->detail_address }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <table id="sample-table-1" class="table table-bordered table-hover"
                   aria-describedby="sample-table-1_info">
                <thead>
                <tr style="background-color: #DEDEDE">商品</tr>
                <tr style="background-color: #DEDEDE">单价</tr>
                <tr style="background-color: #DEDEDE">数量</tr>
                <tr style="background-color: #DEDEDE">操作</tr>
                </thead>
                <tbody>
                @inject('productPresenter', 'App\Presenters\ProductPresenter')
                @foreach ($order->orderDetails as $orderDetail)
                    <tr>
                        <td>
                            <a href="{{ url("/home/products/{$orderDetail->product->id}") }}"
                               class="J_MakePoint">
                                <img src="{{ $productPresenter->getThumbLink($orderDetail->product->thumb) }}"
                                     style="width: 20px;height: 20px;">
                            </a>
                        </td>
                        <td>
                            <a href="{{ url("/home/products/{$orderDetail->product->id}") }}">
                                {!! $orderDetail->product->title !!}
                            </a>
                        </td>
                        <td>
                            {{ $orderDetail->product->price }}
                        </td>
                        <td>
                            <span>×</span>{{ $orderDetail->numbers }}
                        </td>
                        <td>
                            <a href="{{ url("/home/products/{$orderDetail->product->id}") }}">
                                评论</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection