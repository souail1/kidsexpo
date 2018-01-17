@extends("admin.layout.main")

@section("content")
	<form class="layui-form layui-form-pane" style="width:60%;">
		<div class="layui-form-item">
			<label class="layui-form-label">文章分类</label>
			<div class="layui-input-block">
				<select name="cate" lay-filter="cate">
					<option value="0" @if ($articles['cate'] == 0) selected @endif>展会新闻</option>
					<option value="1"  @if ($articles['cate'] == 1) selected @endif>业界资讯</option>
					<option value="2"  @if ($articles['cate'] == 2) selected @endif>政策法规</option>
				</select>
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">标题</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="title" lay-verify="required" value="{{$articles['title']}}">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">内容</label>
			<script id="container" name="content" type="text/plain">
				{{$articles['id']}}
			</script>
		</div>
		<div class="layui-form-item">
			<input type="radio" name="status" value="1" title="发布"  @if ($articles['status'] == 1) checked @endif>
			<input type="radio" name="status" value="-1" title="暂不发布"  @if ($articles['status'] == -1) checked @endif>
		</div>
		<input type="hidden" name="id" value="{{$articles['id']}}">
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
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
	</script>

	<!-- 编辑器容器 -->

	<script>

        layui.config({base: '/layadmin/modul/common/'}).use(['form', 'dialog', 'his','layedit'],function(){
            var form = layui.form,
                dialog = layui.dialog,
                $ = layui.jquery,
                his = layui.his;

            form.on("submit(addarticle)",function(data){
                if ($('.article_group:checked').length == 0) dialog.msg('请选择用户组');
                var loadIndex = dialog.load('数据提交中，请稍候');

                his.ajax({
                    url: '/admin/article'
                    ,type: 'put'
                    ,data: data.field
                    ,contentType: 'form'
                    ,complete: function(){
                        dialog.close(loadIndex);
                    }
                    ,error: function (msg) {
                        dialog.error(msg);
                    }
                    ,success: function (msg, data, meta) {
                        dialog.msg("文章修改成功！");
                        dialog.closeAll('iframe');
                        parent.location.reload();
                    }
                });
                return false;
            })
        })

	</script>
@endsection