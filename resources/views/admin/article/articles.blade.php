@extends("admin.layout.main")

@section("content")
    <blockquote class="layui-elem-quote news_search">
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" value="" placeholder="文章标题" class="layui-input search_input">
            </div>
            <a class="layui-btn search_btn">查询</a>
        </div>
        <div class="layui-inline">
            <a class="layui-btn layui-btn-normal add_btn">新增文章</a>
        </div>
        <div class="layui-inline">
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
    </blockquote>
    <table id="articles" lay-filter="articletab"></table>
@endsection

@section("js")
    <script type="text/html" id="active">
        @{{# if(d.status == 1){ }}
        <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="active">已发布</a>
        @{{#  } else { }}
        <a class="layui-btn layui-btn-warm layui-btn-danger layui-btn-xs" lay-event="active">未发布</a>
        @{{# } }}
    </script>
    <script type="text/html" id="cate">
        @{{# if(d.cate == 0){ }}
        <a class="" lay-event="cate">展会新闻</a>
        @{{# } }}
        @{{# if(d.cate == 1){ }}
        <a class="" lay-event="cate">业界资讯</a>
        @{{# } }}
        @{{# if(d.cate == 2){ }}
        <a class="" lay-event="cate">法律法规</a>
        @{{# } }}
    </script>
    <script type="text/html" id="op">
        <a class="layui-btn layui-btn-xs edit_article" lay-event="edit">
            <i class="layui-icon">&#xe642;</i>
            编辑
        </a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">
            <i class="layui-icon"></i>
            删除
        </a>
    </script>
    <script>
        layui.config({base: '/layadmin/modul/common/'}).use(['table', 'dialog', 'his'], function(){
            var table = layui.table
                ,dialog = layui.dialog
                ,his = layui.his
                ,$ = layui.$;
            table.render({
                elem: '#articles'
                ,url: '/admin/articles' //数据接口
                ,method: 'get'
                ,page: true //开启分页
                ,limit: 10
                ,layout: ['prev', 'page', 'next']
                ,limits: [10, 20]
                ,cols: [[ //表头
                    {field: 'id', title: 'ID', width:80, sort: true}
                    ,{field: 'title', title: '标题'}
                    ,{field: 'cate', title: '分类',templet: '#cate'}
                    ,{field: 'created_at', title:'创建时间', sort: true}
                    ,{field: 'updated_at', title:'修改时间', sort: true,}
                    ,{field: 'status', title: '是否发布', width: 80, templet: '#active'}
                    ,{title: '操作', width: 160, toolbar: '#op'}
                ]]
                ,response: {
                    statusName: 'code'
                    ,statusCode: 0
                    ,msgName: 'msg'
                    ,countName: 'meta'
                    ,dataName: 'data'
                }
//				,skin: 'row' // 'line', 'row', 'nob'
                ,even: false //开启隔行背景
//                ,size: 'lg' // 'sm', 'lg'

            });

            table.on('tool(articletab)', function(obj){
                var data = obj.data;      //获得当前行数据
                var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
                var tr = obj.tr;          //获得当前行 tr 的DOM对象

                if (layEvent == 'active') {
                    dialog.confirm('确认进行此操作', function () {
                        var loadIndex = dialog.load('修改中，请稍候');
                        var newStatus = (data.status == 1) ? 0 : 1;
                        his.ajax({
                            url: '/admin/article'
                            ,type: 'patch'
                            ,data: {id: data.id, status: newStatus}
                            ,complete: function () {
                                dialog.close(loadIndex);
                            }
                            ,error: function (msg) {
                                dialog.error(msg);
                            }
                            ,success: function (msg, data, meta) {
                                dialog.msg('已更改成功');
                                obj.update({
                                    status: newStatus
                                });
                            }
                        });
                    });
                } else if (layEvent == 'edit') {
                    dialog.open('编辑文章', '/admin/article/'+data.id+'/edit');

                } else if (layEvent == 'del') {
                    dialog.confirm('确认删除', function () {
                        var loadIndex = dialog.load('删除中，请稍候');
                        his.ajax({
                            url: '/admin/article'
                            ,type: 'delete'
                            ,data: {id: data.id}
                            ,complete: function () {
                                dialog.close(loadIndex);
                            }
                            ,error: function (msg) {
                                dialog.error(msg);
                            }
                            ,success: function () {
                                dialog.msg('删除成功');
                                obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                            }
                        });
                    })

                }

            });

            function flushTable (cond, sortObj) {
                var query = {
                    where: {
                        cond: cond
                    }
                    ,page: {
                        curr: 1
                    }
                };
                if (sortObj != null) {
                    query.initSort = sortObj;
                    query.where.sortField = sortObj.field;   // 排序字段
                    query.where.order = sortObj.type;        //排序方式
                }
                table.reload('articles', query);
            }

            // 搜索
            $('.search_btn').click(function () {
                var cond = $('.search_input').val();
                flushTable(cond);
            });

            // 排序
            table.on('sort(articletab)', function (obj) {
                var cond = $('.search_input').val();
                flushTable(cond, obj);
            });

            // 添加文章
            $('.add_btn').click(function () {
                dialog.open('添加文章', '/admin/article/create');
            });

        });
    </script>
@endsection



