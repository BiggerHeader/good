@extends('layouts.user')


@section('style')
    <style>
        th, td {
            text-align: center;
            border: 1px solid #ddd;
            padding: 5px 10px;
        }

        td a.uuid {
            color: #00a0e9;
        }
    </style>

    <script>
        function clickaction(ele) {
            var orderid = $(ele).next('input[name=orderid]').val();
            var data = JSON.stringify({
                orderid: orderid
            })
            console.log($(ele).next('input[name=orderid]').val());
            $.ajax(
                {
                    url: 'http://yaf.dtcode.cn/order/order/confire',
                    type: 'post',
                    data: data,
                    dataType: "json",
                    success: function (respones) {
                        if (respones.code == 10000) {
                             alert(respones.msg);
                            window.location.href = '{{url('/user/orders')}}'
                        } else {
                            alert(respones.msg);
                        }
                    }
                }
            )
        }
    </script>
@endsection

@section('main')
    <div class="main-wrap">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">订单列表</strong> /
                <small>Electronic&nbsp;bill</small>
            </div>
        </div>
        <hr>
        <table width="100%">
            <thead>
            <tr>
                <th class="time">ID</th>
                <th class="time">订单号</th>
                <th class="name">创建时间</th>
                <th class="amount">金额</th>
                <th class="status">状态</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($orders as $order)
                <tr style="padding-left: 20px;">
                    <td>
                        {{$order->id}}

                    </td>
                    <td class="time">

                        <a class="uuid" href="{{ url("/user/orders/{$order->id}") }}">{{ $order->uuid }}</a>
                    </td>
                    <td class="title name">
                        <p class="content">
                            {{ $order->created_at }}
                        </p>
                    </td>

                    <td class="amount">
                        <span class="amount-pay">{{ $order->total_money }}</span>
                    </td>
                    <td class="status">
                        @if($order->status==1)
                            <button class="btn btn-default" role="button" id="confire" onclick=clickaction(this)>确认收货
                            </button>
                            <input type="hidden" value="{{$order->id}}" name="orderid">
                        @elseif($order->status==3)
                            <button type="button" class="btn btn-info" disabled>订单已取消</button>
                        @elseif($order->status==0)
                            <button type="button" class="btn btn-info" disabled>未发货</button>
                        @elseif($order->status==2)
                            <button type="button" class="btn btn-info" disabled>已收货</button>
                        @endif

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

@endsection