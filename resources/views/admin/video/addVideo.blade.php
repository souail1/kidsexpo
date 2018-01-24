@extends("admin.layout.main")

@section("content")
	<form class="layui-form layui-form-pane" style="width:60%;">
		<div class="layui-form-item">
			<label class="layui-form-label">标题</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="title" lay-verify="required" placeholder="请输入文章标题">
			</div>
		</div>
        <div class="layui-form-item">
            <label class="layui-form-label">简介</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" name="brief" lay-verify="required" placeholder="请输入简介">
            </div>
        </div>

            <div class="layui-upload">
                <button type="button" class="layui-btn" id="file"><i class="layui-icon"></i>上传视频</button>
            </div>

		<div class="layui-form-item">
			<label class="layui-form-label">排序</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input" name="sort" lay-verify="required" placeholder="请输入排序号">
			</div>
		</div>
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" type="button" lay-submit lay-filter="addvideo">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		    </div>
		</div>

        <input type="hidden" name="file" value=""/>
	</form>
@endsection

@section("js")
    <script>
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;

            //普通图片上传
            var uploadInst = upload.render({
                elem: '#file'
                ,url: 'http://kidsexpo.cc/upload/file'
                ,accept: 'video' //视频
                ,size: 1024 * 1024 * 150
                ,done: function(res){
                    //上传完毕回调
                    console.log(res.file)
                    $('input[name=file]').val(res.file);
                }
                ,error: function(){
                    //请求异常回调
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

            form.on("submit(addvideo)",function(data){

                his.ajax({
                    url: '/admin/video'
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
