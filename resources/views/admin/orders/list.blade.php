@extends('layouts.admin')
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
@endsection

@section('main')
    <div class="page-container">
        @if (session()->has('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                {{ session('status') }}
            </div>
        @endif
        <div class="form-group skin-minimal">
            <div class="mt-20 skin-minimal">
                <div class="radio-box">
                    <input type="radio" id="radio" name="demo-radio" checked value="-1">
                    <label for="radio-2">全部</label>
                </div>
                <div class="radio-box">
                    <input type="radio" id="radio" name="demo-radio" value="0">
                    <label for="radio-1">未发货</label>
                </div>
                <div class="radio-box">
                    <input type="radio" id="radio" name="demo-radio" value="1">
                    <label for="radio-1">发货</label>
                </div>
                <div class="radio-box">
                    <input type="radio" id="radio" name="demo-radio" value="2">
                    <label for="radio-1">已确认收货</label>
                </div>
            </div>
            <input type="text" placeholder="输入订单ID" class="input-text radius size-L" id="orderid" name="orderid">
            <input class="btn btn-primary size-L radius" type="button" name="tijao" id="tijao" value="查询">
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                <tr class="text-c">
                    <th width="40">订单iD</th>
                    <th width="60">创建时间</th>
                    <th width="100">状态</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($orders as $order)
                    <tr style="padding-left: 20px;">
                        <td class="time">
                            <p>
                                <a class="uuid" href="{{ url("/user/orders/{$order->id}") }}">{{ $order->uuid }}</a>
                            </p>
                        </td>
                        <td class="title name">
                            <p class="content">
                                {{ $order->created_at }}
                            </p>
                        </td>

                        <td class="amount">
                            <span class="amount-pay">{{ $order->total_money }}</span>
                        </td>
                        <td>
                            @if($order->status == 0 )
                                <input class="btn btn-primary-outline radius" type="button"
                                       onClick="change_order_status(this, '{{ $order->uuid }}')" value="发货">
                                <input type="hidden" id="status" name="status" value="1">

                            @else
                                <input class="btn btn-warning-outline radius" type="button"
                                       onClick="change_order_status(this, '{{ $order->uuid }}')" value="取消发货">
                                <input type="hidden" id="status" name="status" value="0">

                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')

    <script type="text/javascript">
        $(function () {
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            })
        });
        $('#tijao').click(function () {
            var radion_checked = $("input[name=demo-radio]:checked").val();
            var orderid = $("#orderid").val();

            $.ajax({
                url: '/admin/orders/' + radion_checked + '/' + orderid + '/',
                dataType: 'json',
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {
                    console.log(res);
                }

            })
        })

        function change_order_status(obj, uuid) {
            var status_obj = $(obj).next();
            var status = $(obj).next().val();
            layer.confirm('确认要发货吗？', function (index) {
                    layer.close(index);
                    var url = "{{ url('/admin/order/modify') }}";

                    $.ajax({
                        url: url,
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            uuid: uuid,
                            status: status,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (res) {
                            if (res.code == 200) {
                                if (res.status == 0) {
                                    //0 =》 1 已经发货
                                    $(obj).addClass('btn-primary-outline').removeClass('btn-warning-outline').val('发货');
                                    status_obj.val(1)
                                } else {
                                    //已经发货
                                    $(obj).removeClass('btn-primary-outline').addClass('btn-warning-outline').val('取消发货');
                                    status_obj.val(0)
                                }
                                layer.msg(res.msg, {icon: 1, time: 1000});

                            } else {
                                layer.msg('修改失败！', {icon: 2, time: 1000});
                            }
                        }

                    })
                    ;
                }
            )
            ;
        }
    </script>

@endsection