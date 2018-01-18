@extends("admin.layout.main")

@section("css")
	<link rel="stylesheet" href="/layadmin/extra/treegrid/css/jquery.treegrid.css" media="all" />
@endsection

@section("content")
	<blockquote class="layui-elem-quote news_search">
		<div class="layui-inline">
			<a class="layui-btn cateAdd_btn" style="background-color:#5FB878">添加栏目</a>
		</div>
		<div class="layui-inline">
			<div class="layui-form-mid layui-word-aux">&nbsp;&nbsp;&nbsp;&nbsp;栏目更改后,刷新页面即生效</div>
		</div>
	</blockquote>
	<div class="layui-form links_list">
		<table class="layui-table tree">
			<colgroup>
				<col width="100px">
				<col width="20%">
				<col width="10%">
				<col width="20%">
				<col width="20%">
			</colgroup>
			<thead>
			<tr>
				<th>#</th>
				<th style="text-align:left;">栏目名称</th>
				<th>排序</th>
				<th>是否显示</th>
				<th>操作</th>
			</tr>
			</thead>
			<tbody class="links_content">
			@foreach ($cates as $cate)
				<tr class="treegrid-{{$cate['id']}} @if($cate['pid']!=0) treegrid-parent-{{$cate['pid']}} @endif">
					<td>{{ $cate['id'] }}</td>
					<td style="text-align:left;">{{ $cate['ltitle'] }}</td>
					<td>
						<input data-id="{{$cate['id']}}" type="text" class="layui-input sort_input"  value="{{$cate['sort']}}">
					</td>
					<td>
						<input data-id="{{$cate['id']}}" type="checkbox" lay-skin="switch" lay-text="是|否" lay-filter="isShow"
							   @if ($cate['status'] == 1) checked @endif>
					</td>
					<td>
						<a data-id="{{$cate['id']}}" class="layui-btn layui-btn-xs cate_edit">
							<i class="layui-icon">&#xe642;</i>
							编辑
						</a>
						<a data-id="{{$cate['id']}}" class="layui-btn layui-btn-danger layui-btn-xs cate_del">
							<i class="layui-icon"></i>
							删除
						</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
@endsection

@section("js")
	<script type="text/javascript" src="/layadmin/modul/common/jquery.min.js"></script>
	<script type="text/javascript" src="/layadmin/extra/treegrid/js/jquery.treegrid.js"></script>
	<script>
        layui.config({base: '/layadmin/modul/common/'}).use(['form','dialog', 'his'],function(){
            var form = layui.form,
                dialog = layui.dialog
                ,his = layui.his;

            $('.tree').treegrid({initialState: 'collapsed'});

            //添加栏目
            $(".cateAdd_btn").click(function(){
                dialog.open('添加栏目', '/admin/cate/create');
            })

            //编辑栏目
            $("body").on("click",".cate_edit",function(){  //编辑
                var id = $(this).attr('data-id');
                dialog.open('编辑栏目', '/admin/cate/'+id+'/edit');
            })

            $("body").on("click",".cate_del",function(){  //删除
                var _this = $(this);
                var id = $(this).attr('data-id');
                dialog.confirm('确定删除此信息？', function () {
                    var loadIndex = dialog.load('信息删除中');
                    his.ajax({
                        url: '/admin/cate'
                        ,type: 'delete'
                        ,data: {id: id}
                        ,complete: function () {
                            dialog.close(loadIndex);
                        }
                        ,error: function (msg) {
                            dialog.error(msg);
                        }
                        ,success: function (msg, data, meta) {
                            dialog.msg("删除成功");
                            _this.parents("tr").remove();
                        }
                    });
                });

            })

            form.on('switch(isCheck)', function(data){
                var id = $(this).attr('data-id');
                var orig = $(this).prop('checked');
                var check;
                if (orig) {
                    check = 1;
                } else {
                    check = 0;
                }
                var loadIndex = dialog.load('修改中，请稍候');
                his.ajax({
                    url: '/admin/cate'
                    ,type: 'patch'
                    ,data: {id: id, val: check, key: 'check'}
                    ,complete: function(){
                        dialog.close(loadIndex);
                    }
                    ,error: function(msg){
                        dialog.error(msg, function () {
                            location.reload();
                        });
                    }
                    ,success: function(msg, data, meta){
                        dialog.msg("已更改成功");
                    }
                });
                return false;
            })

            form.on('switch(isShow)', function(data){
                var id = $(this).attr('data-id');
                var orig = $(this).prop('checked');
                var status;
                if (orig) {
                    status = 1;
                } else {
                    status = 0;
                }
                var loadIndex = dialog.load('修改中，请稍候');
                his.ajax({
                    url: '/admin/cate'
                    ,type: 'patch'
                    ,data: {id: id, val: status, key: 'status'}
                    ,complete: function(){
                        dialog.close(loadIndex);
                    }
                    ,error: function(msg){
                        dialog.error(msg, function () {
                            location.reload();
                        });
                    }
                    ,success: function(msg, data, meta){
                        dialog.msg("已更改成功");
                    }
                });
                return false;
            })

            $('.sort_input').change(function(){
                var id = $(this).attr('data-id');
                var sort = $(this).val();
                sort = Number(sort);
                var loadIndex = dialog.load('修改中，请稍候');
                his.ajax({
                    url: '/admin/cate'
                    ,type: 'patch'
                    ,data: {id: id, val: sort, key: 'sort'}
                    ,complete: function(){
                        dialog.close(loadIndex);
                    }
                    ,error: function(msg){
                        dialog.error(msg, function () {
                            location.reload();
                        });
                    }
                    ,success: function(msg, data, meta){
                        dialog.msg("已更改成功");
                    }
                });
                return false;
            });

        })
	</script>
@endsection
