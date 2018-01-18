@extends("admin.layout.main")

@section("content")
    <form class="layui-form layui-form-pane" style="width:60%;">
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" lay-verify="required" autocomplete="off" class="layui-input"
                       maxlength="50" value="{{$banners['title']}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片</label>
            <button type="button" class="layui-btn" id="upload" style="vertical-align: top;">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>
            <div class="layui-inline" style="width:300px;">
                <input type="hidden" name="img" value="{{$banners['img']}}">
            </div>
            <div id="review" style="margin-left:110px;">
                <notempty name="img">
                    <img src="http://kidsexpo.cc/{{$banners['img']}}" width="100px">
                </notempty>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" name="sort" lay-verify="required|number" autocomplete="off" class="layui-input"
                       maxlength="8" value="{{$banners['sort']}}">
            </div>
        </div>
        <input type="hidden" name="id" value="{{$banners['id']}}">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" type="button" lay-submit lay-filter="addbanner">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
@endsection

@section("js")
    <script>
        layui.use('upload', function(){
            var $ = layui.jquery,
                form = layui.form,
                upload = layui.upload;
            //创建上传
            var uploadInst = upload.render({
                // 绑定元素
                elem: '#upload',
                // 上传接口
                url: 'http://kidsexpo.cc/upload',
                // 上传文件类型
                accept: 'images',
                // 文件后缀
                exts: 'jpg|png|gif|bmp|jpeg',
                // 自动上传
                auto: true,
                // 文件大小Kb
                size: 3072,
                // 不接受文件拖拽
                drag: false,
                done: function (res) {
                    console.log(res)
                    if (res.code > 0) {
                        layer.open({content: res.msg});
                        return false;
                    }
                    $('input[name=img]').val(res.file);
                    $('#review').html('<img src="http://kidsexpo.cc/' + res.file + '" width="100px"/>');
                    //上传完毕回调
                }, error: function () {
                    layer.open({content: '上传失败'});
                }
            });

        });
        layui.config({base: '/layadmin/modul/common/'}).use(['form', 'dialog', 'his'],function(){
            var form = layui.form,
                dialog = layui.dialog,
                $ = layui.jquery,
                his = layui.his;

            form.on("submit(addbanner)",function(data){

                his.ajax({
                    url: '/admin/banner'
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
                        dialog.msg("修改成功！");
                        dialog.closeAll('iframe');
                        parent.location.reload();
                    }
                });
                return false;
            })
        })
    </script>
@endsection
