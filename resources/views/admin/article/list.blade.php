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
    <script type="text/html" id="op">
        <a class="layui-btn layui-btn-xs edit_user" lay-event="edit">
            <i class="layui-icon">&#xe642;</i>
            编辑
        </a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">
            <i class="layui-icon"></i>
            删除
        </a>
    </script>
    <script type="text/javascript" src="/layadmin/modul/article/articles.js"></script>
@endsection



