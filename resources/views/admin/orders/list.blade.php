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
        <table id="demo" class="layui-table" lay-filter="demo"></table>
        <script type="text/html" id="order_status">
            <input type="checkbox" order_id="@{{ d.id }}" uuid="@{{ d.uuid }}" name="status" value="@{{d.status}}"
                   lay-skin="switch" lay-text="已发货|未发货" lay-filter="status" @{{ d.status =='1'  ? 'checked' : '' }}>
        </script>
        <script type="text/html" id="checkboxTpl">
            <input type="checkbox" name="lock"  uuid="@{{ d.uuid }}"  value="@{{d.id}}" title="订单置无效" lay-filter="lockDemo" @{{ d.status == '3' ? 'checked' : '' }}>
        </script>
        <style>
            [data-field="thumb"] .layui-table-cell {
                height: auto;
            }
        </style>
        <script>
            var tableOption = {
                elem: '#demo',
                url: 'http://yaf.com/order/order/get',
                page: true,
                request: {
                    limitName: 'pageSize'
                },
                response: {
                    statusName: 'code', //数据状态的字段名称，默认：code
                    statusCode: 10000, //成功的状态码，默认：0
                    msgName: 'msg', //状态信息的字段名称，默认：msg
                    countName: 'count', //数据总数的字段名称，默认：count
                    dataName: 'data' //数据列表的字段名称，默认：data
                },
                cols: [[ //表头
                    {field: 'uuid', title: '订单ID'},
                    {field: 'total_money', title: '原总金额'},
                    {field: 'change_money', title: '改动金额(可直接编辑)',edit: 'text'},
                    {field: 'created_at', title: '创建时间', sort: true},
                    {field: 'detail_address', title: '详细地址'},
                    {field: 'status', title: '订单状态', templet: '#order_status',width:100},
                    {field:'lock', title:'是否锁定', width:110, templet: '#checkboxTpl', width:160}
                ]]
            };
            layui.use('table', function () {
                var table = layui.table;
                var form = layui.form;
                var tableIns = table.render(tableOption);
                //监听单元格编辑
                table.on('edit(demo)', function(obj){
                    var value = obj.value //得到修改后的值
                        ,data = obj.data //得到所在行所有键值
                        ,field = obj.field; //得到字段
                    change_order_money(data.id, data.uuid, value,tableIns);
                });

                //监听锁定操作
                form.on('checkbox(lockDemo)', function(obj){
                    var order_id = obj.value;
                    var uuid = $(obj.elem).attr('uuid')
                    change_order_status(order_id, uuid, '3',tableIns);
                });
                //监听性别操作
                form.on('switch(status)', function (obj) {
                    layer.tips(this.value + ' ' + this.name + '：' + obj.elem.checked, obj.othis);
                    console.log(obj);
                    var value = obj.value;
                    var order_id = $(obj.elem).attr('order_id')
                    var uuid = $(obj.elem).attr('uuid')
                    change_order_status(order_id, uuid, value,tableIns);
                });
                //监听工具条
                table.on('tool(demo)', function (obj) {
                    console.log(obj);
                    var data = obj.data;
                    var is_alive = data.is_alive;
                    //上下架
                    if (obj.event === 'status') {
                        layer.msg('ID：' + data.uuid + ' 的查看操作');
                        product_stop(data.id, data.is_alive, tableIns);
                    } else if (obj.event === 'delete') {
                        layer.confirm('真的删除行么', function (index) {
                            product_del(data.id);
                        });
                    }
                });

                $('.demoTable .layui-btn').on('click', function () {
                    var type = $(this).data('type');
                    active[type] ? active[type].call(this) : '';
                });
            });
        </script>
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

        function change_order_money(id, uuid, value,table){
            var url = "http://yaf.com/order/order/modify";
            $.ajax({
                url: url,
                dataType: 'json',
                type: 'POST',
                data: JSON.stringify({
                    id: id,
                    uuid: uuid,
                    change_money: value
                }),
                success: function (res) {
                    if (res.code == 10000) {
                        layer.msg(res.msg, {icon: 1, time: 1000});
                        table.reload({
                            page: {
                                curr: 1 //重新从第 1 页开始
                            }
                        })
                    } else {
                        layer.msg(res.msg, {icon: 2, time: 1000});
                    }
                }
            });
        }

        function change_order_status(id, uuid, status,table) {
            var url = "http://yaf.com/order/order/modify";
            $.ajax({
                url: url,
                dataType: 'json',
                type: 'POST',
                data: JSON.stringify({
                    id: id,
                    uuid: uuid,
                    status: status
                }),
                success: function (res) {
                    if (res.code == 10000) {
                        layer.msg(res.msg, {icon: 1, time: 1000});
                        table.reload({
                            page: {
                                curr: 1 //重新从第 1 页开始
                            }
                        })
                    } else {
                        layer.msg(res.msg, {icon: 2, time: 1000});
                    }
                }
            });
        }
    </script>

@endsection