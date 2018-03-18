@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/admin/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css') }}"
          type="text/css">
@endsection

@section('main')


    <table id="demo" class="layui-table"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="relay">回复</a>
    </script>
    <script>
        layui.use('table', function () {
            var table = layui.table;
            table.render({
                elem: '#demo',
                url: 'http://yaf.com/comment/comment/get',
                page: true,
                where: {
                    product_id: 278
                },
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
                    {field: 'uuid', title: '商品ID'},
                    {field: 'name', title: '商品名'},
                    {field: 'content', title: 'content'},
                    {field: 'create_time', title: 'create_time', sort: true},
                    {field: 'right', title: '操作', align: 'center', toolbar: '#barDemo'}
                ]]
            });
            /* //监听表格复选框选择
             table.on('checkbox(demo)', function (obj) {
             console.log(obj)
             });
             //监听工具条
             table.on('tool(demo)', function (obj) {
             var data = obj.data;
             if (obj.event === 'detail') {
             layer.msg('ID：' + data.id + ' 的查看操作');
             } else if (obj.event === 'del') {
             layer.confirm('真的删除行么', function (index) {
             obj.del();
             layer.close(index);
             });
             } else if (obj.event === 'edit') {
             layer.alert('编辑行：<br>' + JSON.stringify(data))
             }
             });
             var $ = layui.$, active = {
             getCheckData: function () { //获取选中数据
             var checkStatus = table.checkStatus('idTest')
             , data = checkStatus.data;
             layer.alert(JSON.stringify(data));
             }
             , getCheckLength: function () { //获取选中数目
             var checkStatus = table.checkStatus('idTest')
             , data = checkStatus.data;
             layer.msg('选中了：' + data.length + ' 个');
             }
             , isAll: function () { //验证是否全选
             var checkStatus = table.checkStatus('idTest');
             layer.msg(checkStatus.isAll ? '全选' : '未全选')
             }
             };

             $('.demoTable .layui-btn').on('click', function () {
             var type = $(this).data('type');
             active[type] ? active[type].call(this) : '';
             });*/
        });
    </script>
@endsection


@section('script')
@endsection