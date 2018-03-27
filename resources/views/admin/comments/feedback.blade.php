@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/admin/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css') }}"
          type="text/css">
@endsection

@section('main')


    <table id="demo" class="layui-table"></table>
    <script type="text/html" id="feedback_status">
        <input type="checkbox" id="@{{ d.id }}" name="status" value="@{{d.status}}" width="50px"
               lay-skin="switch" lay-text="待处理|已处理" lay-filter="status" @{{ d.status=='1' ? 'checked' : '' }}>
    </script>
    <script>
        var tableOption = {
            elem: '#demo',
            url: 'http://yaf.dtcode.cn/feedback/feedback/get',
            page: true,
            where: {},
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
                {field: 'id', title: '评论ID'},
                {field: 'name', title: '姓名'},
                {field: 'email', title: '邮件'},
                {field: 'content', title: 'content'},
                {field: 'create_time', title: '创建时间', sort: true},
                {field: 'update_time', title: '最后修改时间', sort: true},
                {field: 'right', title: '操作', align: 'center', toolbar: '#feedback_status'}
            ]]
        };
        layui.use('table', function () {
            var table = layui.table;
            var form = layui.form;
            var tableIns = table.render(tableOption);

            form.on('switch(status)', function (obj) {
                layer.tips(this.value + ' ' + this.name + '：' + obj.elem.checked, obj.othis);
                console.log(obj);
                var value = obj.value;
                var id = $(obj.elem).attr('id');

                change_order_status(id, value, tableIns);
            });
        });

        function change_order_status(id, value, table) {
            var url = "http://yaf.dtcode.cn/feedback/feedback/modify";
            $.ajax({
                url: url,
                dataType: 'json',
                type: 'POST',
                data: JSON.stringify({
                    id: id,
                    status: value
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


@section('script')
@endsection