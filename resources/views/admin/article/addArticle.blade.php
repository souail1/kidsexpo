@extends("admin.layout.main")

@section("content")
	<form class="layui-form layui-form-pane" style="width:60%;">
		<div class="layui-form-item">
			<label class="layui-form-label">文章分类</label>
			<div class="layui-input-block">
				<select name="cate" lay-filter="cate">
					<option value="">请选择文章分类</option>
					<option value="0">展会新闻</option>
					<option value="1">业界新闻</option>
					<option value="2">政策法规</option>
				</select>
			</div>
		</div>
		<div class="layui-form-item" style="margin-top: 50px">
			<label class="layui-form-label">标题</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="title" lay-verify="required" placeholder="请输入文章标题">
			</div>
		</div>
		<label class="layui-form-label">内容</label>
		<div class="layui-form-item" style="margin-top: 80px">

			<!-- 编辑器容器 -->
			<script id="container" name="content" type="text/plain"></script>
		</div>
		<div class="layui-form-item">
			<input type="radio" name="status" value="1" title="发布">
			<input type="radio" name="status" value="-1" title="暂不发布">
		</div>

		<div class="layui-form-item">
			<!-- 提交session中的locale -->
			<input type="hidden" name="type" value="{{ $lang }}">
		</div>



		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" type="button" lay-submit lay-filter="addarticle">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		    </div>
		</div>
	</form>
@endsection

@section("js")

	<!-- 配置文件 -->
	<script type="text/javascript" src="{{ asset('vendor/ueditor/ueditor.config.js') }}"></script>
	<!-- 编辑器源码文件 -->
	<script type="text/javascript" src="{{ asset('vendor/ueditor/ueditor.all.js') }}"></script>
	<script>
        window.UEDITOR_CONFIG.serverUrl = '{{ config('ueditor.route.name') }}'
	</script>
	<!-- 实例化编辑器 -->
	<script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.setHeight(400);
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
	</script>


	<script>
        layui.config({base: '/layadmin/modul/common/'}).use(['form', 'dialog', 'his'],function(){
            var form = layui.form,
                dialog = layui.dialog,
                $ = layui.jquery,
                his = layui.his;

            form.on("submit(addarticle)",function(data){
                his.ajax({
                    url: '/admin/article'
                    ,type: 'post'
                    ,data: data.field
                    ,contentType: 'form'
                    ,complete: function(){

                    }
                    ,error: function (msg) {
                        dialog.error(msg);
                    }
                    ,success: function (msg, data, meta) {
                        dialog.msg("文章添加成功！");
                        dialog.closeAll('iframe');
                        parent.location.reload();
                    }
                });
                return false;
            })
        })
	</script>
@endsection
