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
		<div class="layui-form-item">
			<label class="layui-form-label">标题</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="title" lay-verify="required" placeholder="请输入文章标题">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">内容</label>
			<textarea id="content" style="display: none;"></textarea>
		</div>
		<div class="layui-form-item">
			<input type="radio" name="status" value="1" title="发布">
			<input type="radio" name="status" value="-1" title="暂不发布">
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
	<script>
        layui.config({base: '/layadmin/modul/common/'}).use(['form', 'dialog', 'his','layedit'],function(){
            var form = layui.form,
                dialog = layui.dialog,
                $ = layui.jquery,
                his = layui.his;
            var layedit = layui.layedit;
            layedit.build('content'); //建立编辑器

            form.on("submit(addarticle)",function(data){
                if ($('.article_group:checked').length == 0) dialog.msg('请选择用户组');
                var loadIndex = dialog.load('数据提交中，请稍候');

                his.ajax({
                    url: '/admin/article'
                    ,type: 'post'
                    ,data: data.field
                    ,contentType: 'form'
                    ,complete: function(){
                        dialog.close(loadIndex);
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
