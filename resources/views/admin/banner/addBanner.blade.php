@extends("admin.layout.main")

@section("content")
	<form class="layui-form layui-form-pane" style="width:60%;">
		<div class="layui-form-item">
			<label class="layui-form-label">标题</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="title" lay-verify="required" placeholder="请输入文章标题">
			</div>
		</div>
		{{--<div class="layui-form-item">
			<div class="layui-upload">
				<button type="button" class="layui-btn" id="img">上传图片</button>
				<div class="layui-upload-list">
					<img class="layui-upload-img" id="demo1">
					<p id="demoText"></p>
				</div>
			</div>
		</div>--}}
        <div class="layui-upload">
                             <label class="layui-form-label">头像:</label>
                             <div class="layui-upload layui-input-block">
                                     <input type="hidden" name="userImage" value="${ui.userImage }" required lay-verify="required" />
                                     <button type="button" class="layui-btn layui-btn-primary" id="fileBtn"><i class="layui-icon">&#xe67c;</i>选择文件</button>
                                     <button type="button" class="layui-btn layui-btn-warm" id="uploadBtn">开始上传</button>
                                 </div>
                         </div>

		<div class="layui-form-item">
			<label class="layui-form-label">排序</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="sort" lay-verify="required" placeholder="请输入排序号">
			</div>
		</div>
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" type="button" lay-submit lay-filter="addbanner">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		    </div>
		</div>
	</form>
@endsection

@section("js")
     <script type="text/javascript">
                 layui.use('upload',function(){
                        var upload = layui.upload;
                        upload.render({
                                 elem: '#fileBtn'
                            ,url: 'upload'
                             ,accept: 'file'
                             ,auto: false
                             ,bindAction: '#uploadBtn'
                            ,done: function(res){
                                    alert(res.data.src);
                                    $("[name=userImage]").val(res.data.src);
                                 }
                         });
                     });
            </script>
	<script>
        layui.config({base: '/layadmin/modul/common/'}).use(['form', 'dialog', 'his','layedit'],function(){
            var form = layui.form,
                dialog = layui.dialog,
                $ = layui.jquery,
                his = layui.his;

            form.on("submit(addbanner)",function(data){
                if ($('.banner_group:checked').length == 0) dialog.msg('请选择用户组');
                var loadIndex = dialog.load('数据提交中，请稍候');

                his.ajax({
                    url: '/admin/banner'
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
                        dialog.msg("添加成功！");
                        dialog.closeAll('iframe');
                        parent.location.reload();
                    }
                });
                return false;
            })
        })
	</script>
@endsection
