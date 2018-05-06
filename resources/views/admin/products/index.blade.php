@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/admin/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css') }}"
          type="text/css">
@endsection

@section('main')
    <div>
        <div class="page-container">
            <table id="demo" class="layui-table" lay-filter="demo"></table>
            <script type="text/html" id="barDemo" lay-filter="laytpl">
                <a class="layui-btn layui-btn-xs" lay-event="status" ><i
                            class="Hui-iconfont">&#xe63c;</i></a>
                <a class="layui-btn layui-btn-xs" lay-event="edit" title="编辑" href="/admin/products/@{{ d.id }}/edit"><i
                            class="Hui-iconfont">&#xe6df;</i></a>
                <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="delete" title="删除"><i
                            class="Hui-iconfont">&#xe6e2;</i></a>
            </script>
            <script type="text/html" id="thumb" lay-filter="laytpl">
                <img style="height: 90px;width:auto;" title="d.name"
                     src="/storage/@{{d.thumb}}">
            </script>
            <script type="text/html" id="status" lay-filter="laytpl">
                @{{# if(d.is_alive === '1'){ }}
                <span class="label label-success radius product_status">上架</span>
                @{{# }else{ }}
                <span class="label label-success radius product_status">下架</span>
                @{{# } }}
            </script>
            <style>
                [data-field="thumb"] .layui-table-cell {
                    height: auto;
                }
            </style>
            <script>
                var tableOption = {
                    elem: '#demo',
                    url: 'http://yaf.dtcode.cn/product/product/get',
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
                        {field: 'uuid', title: '商品ID'},
                        {field: 'name', title: '产品名称'},
                        {field: 'thumb', title: '缩略图', templet: '#thumb', style: 'height: 90px'},
                        {field: 'price_original', title: '原价', sort: true},
                        {field: 'price', title: '售价', sort: true},
                        /*  {field: 'create_time', title: '收藏数', sort: true},
                         *   {field: 'updated_at', title: '最后修改时间', sort: true},
                         * */
                        {field: 'comment_count', title: ' 评论数', sort: true},
                        {field: 'created_at', title: '创建时间', sort: true},
                        {field: 'is_live', title: '状态', templet: '#status'},
                        {field: 'right', title: '操作', align: 'center', toolbar: '#barDemo'}
                    ]]
                };
                layui.use('table', function () {
                    var table = layui.table;
                    var tableIns = table.render(tableOption);
                    //监听表格复选框选择
                    /*  table.on('checkbox(demo)', function (obj) {
                     console.log(obj)
                     });*/
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
    </div>
@endsection


@section('script')
    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript"
            src="{{ asset('assets/admin/lib/datatables/1.10.0/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/lib/laypage/1.2/laypage.js') }}"></script>
    <script type="text/javascript">
        // 数据表格排序
        /* $('.table-sort').dataTable({
         "aaSorting": [[1, "desc"]],//默认第几个排序
         "bStateSave": true,//状态保存
         "aoColumnDefs": [
         {"orderable": false, "aTargets": [0, 2, 6]}// 制定列不参与排序
         ]
         });*/

        /*产品-查看*/
        function product_show(title, url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*产品-下架*/
        var product_status = -1;
        function product_stop(id, status, table) {

            layer.confirm('确认要修改吗？', function (index) {
                layer.close(index);
                var url = "{{ url('/admin/products/change/alive') }}/" + id;
                $.post(url, {is_alive: status, _token: '{{ csrf_token() }}'}, function (res) {
                    product_status = (product_status == 1) ? 0 : 1;
                    if (res.code == 200) {
                        layer.msg(res.msg, {icon: 1, time: 1000});
                        table.reload({
                            page: {
                                curr: 1 //重新从第 1 页开始
                            }
                        })
                    } else {
                        layer.msg(res.msg, {icon: 2, time: 1000});
                    }

                });
            });
        }


        /*产品-删除*/
        function product_del(id) {
            $.ajax({
                url: 'http://yaf.dtcode.cn/product/product/delete',
                data: JSON.stringify({id: id}),
                type: 'POST',
                contentType: 'application/json',
                dataType: 'json',
                success: function (respones) {
                    if (respones.code == 10000) {
                        layer.msg(respones.msg, {icon: 1, time: 1000});
                        table.reload({
                            page: {
                                curr: 1 //重新从第 1 页开始
                            }
                        })
                    } else {
                        layer.msg(respones.msg, {icon: 2, time: 1000});
                    }
                }
            });
        }
    </script>
@endsection