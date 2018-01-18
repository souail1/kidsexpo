@extends("admin.layout.main")

@section("content")
	<form class="layui-form layui-form-pane" style="width:80%;">
		<div class="layui-form-item">
			<label class="layui-form-label">父级</label>
			<div class="layui-input-block">
                <select name="pid">
                    <option value="0">默认顶级</option>
                    @foreach($cates as $vo)
                        <option data-level="{{$vo['level']}}" value="{{$vo['id']}}">{{$vo['ltitle']}}</option>
                    @endforeach
                </select>
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">栏目名称</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="title" value="{{$cate->title}}" lay-verify="required" placeholder="请输入栏目名称">
			</div>
		</div>
		<input type="hidden" name="id" value="{{$cate->id}}">
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" lay-submit type="button" lay-filter="editcate">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		    </div>
		</div>
	</form>
@endsection

@section("js")
	<script>
        layui.config({base: '/layadmin/modul/common/'}).use(['form','dialog','his'],function(){
            var form = layui.form,
                dialog = layui.dialog,
                his = layui.his
                ,$ = layui.$;

            var selectPid = $('[name="id"]').val();
            $('[name="pid"]').val([selectPid]);
            form.render('select');

            form.on("submit(editcate)",function(data){
                var loadIndex = dialog.load('数据提交中，请稍候');
                his.ajax({
                    url: '/admin/cate'
                    ,type: 'put'
                    ,data: data.field
                    ,complete: function () {
                        dialog.close(loadIndex);
                    }
                    ,error: function (msg) {
                        dialog.error(msg);
                    }
                    ,success: function (msg, data, meta) {
                        dialog.msg("更新成功！");
                        dialog.closeAll('iframe');
                        parent.location.reload();
                    }
                });
                return false;
            })

        })
	</script>
@endsection
