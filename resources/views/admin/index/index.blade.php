<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>kidsexpo</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/layadmin/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/layadmin/modul/index/index.css" media="all" />
</head>
<body class="main_body">
<div class="layui-layout layui-layout-admin">
    <!-- 顶部 -->
    <div class="layui-header header">
        <div class="layui-main">
            <a href="#" class="logo">kidsexpo admin</a>
            <!-- 显示/隐藏菜单 -->
            <a href="javascript:;" class="hideMenu"><i class="layui-icon">&#xe638;</i></a>
            <!-- 天气信息 -->
            <div class="weather" pc>
                <div id="tp-weather-widget"></div>
                <script>(function(T,h,i,n,k,P,a,g,e){g=function(){P=h.createElement(i);a=h.getElementsByTagName(i)[0];P.src=k;P.charset="utf-8";P.async=1;a.parentNode.insertBefore(P,a)};T["ThinkPageWeatherWidgetObject"]=n;T[n]||(T[n]=function(){(T[n].q=T[n].q||[]).push(arguments)});T[n].l=+new Date();if(T.attachEvent){T.attachEvent("onload",g)}else{T.addEventListener("load",g,false)}}(window,document,"script","tpwidget","//widget.seniverse.com/widget/chameleon.js"))</script>
                <script>tpwidget("init", {
                        "flavor": "slim",
                        "location": "WX4FBXXFKE4F",
                        "geolocation": "enabled",
                        "language": "zh-chs",
                        "unit": "c",
                        "theme": "chameleon",
                        "container": "tp-weather-widget",
                        "bubble": "disabled",
                        "alarmType": "badge",
                        "color": "#FFFFFF",
                        "uid": "U9EC08A15F",
                        "hash": "039da28f5581f4bcb5c799fb4cdfb673"
                    });
                    tpwidget("show");</script>
            </div>

            <!-- 顶部右侧login out菜单 -->
            <ul class="layui-nav top_menu">
                {{--<li class="layui-nav-item showNotice" id="showNotice" pc>--}}
                    {{--<a href="javascript:;"><i class="layui-icon"></i><cite>系统公告</cite></a>--}}
                {{--</li>--}}

                        <li class="layui-nav-item"><a href="{{ route('lang.change', 'cn') }}">简体中文</a></li>
                        <li class="layui-nav-item"><a href="{{ route('lang.change', 'en') }}">English</a></li>

                <li class="layui-nav-item" pc>
                    <a href="javascript:;">
                        <img src="/layadmin/modul/index/face.jpg" class="layui-circle" width="35" height="35">
                        <cite>{{$user->username}}</cite>
                    </a>
                    <dl class="layui-nav-child">
                        {{--<dd><a href="javascript:;" data-url="page/user/userInfo.html"><i class="layui-icon" data-icon="icon-zhanghu"></i><cite>个人资料</cite></a></dd>--}}
                        <dd><a href="javascript:;" data-url="/admin/user/password/edit"><i class="layui-icon" data-icon="&#xe620;">&#xe620;</i><cite>修改密码</cite></a></dd>
                        <dd><a href="javascript:;" class="changeSkin"><i class="layui-icon" data-icon="&#xe61b;">&#xe61b;</i><cite>更换皮肤</cite></a></dd>
                        <dd><a href="/admin/logout" class="signOut"><i class="layui-icon">&#xe64d;</i><cite>退出</cite></a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <!-- 左侧导航 -->
    <div class="layui-side">
            <div class="navBar layui-side-scroll" style="height: 714px;">
                <ul class="layui-nav layui-nav-tree">
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-url="/">
                            <i class="iconfont icon-computer" data-icon="icon-computer"></i>
                            <cite>后台首页</cite>
                        </a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-url="/admin/rules">
                            <i class="iconfont icon-text" data-icon="icon-text"></i>
                            <cite>权限管理</cite>
                        </a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-url="/admin/cates">
                            <i class="iconfont icon-text" data-icon="icon-text"></i>
                            <cite>栏目管理</cite>
                        </a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-url="/admin/articlesList">
                            <i class="iconfont icon-text" data-icon="icon-text"></i>
                            <cite>文章列表</cite>
                        </a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-url="/admin/videosList">
                            <i class="layui-icon" data-icon=""></i>
                            <cite>视频管理</cite>
                        </a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-url="">
                            <i class="layui-icon" data-icon=""></i>
                            <cite>幼儿园管理</cite>
                        </a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" data-url="/admin/singlesList">
                            <i class="layui-icon" data-icon=""></i>
                            <cite>单页管理</cite>
                        </a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;">
                            <i class="layui-icon" data-icon=""></i>
                            <cite>组件管理</cite>
                            <span class="layui-nav-more"></span>
                        </a>
                        <dl class="layui-nav-child">
                            <dd>
                                <a href="javascript:;" data-url="">
                                    <i class="layui-icon" data-icon=""></i>
                                    <cite>友情链接</cite>
                                </a>
                            </dd>
                            <dd>
                                <a href="javascript:;" data-url="/admin/bannersList">
                                    <i class="layui-icon" data-icon=""></i>
                                    <cite>Banner管理</cite>
                                </a>
                            </dd>
                            <dd>
                                <a href="javascript:;" data-url="">
                                    <i class="layui-icon" data-icon=""></i>
                                    <cite>观众网上预登记</cite>
                                </a>
                            </dd>
                            <dd>
                                <a href="javascript:;" data-url="">
                                    <i class="layui-icon" data-icon=""></i>
                                    <cite>订阅管理</cite>
                                </a>
                            </dd>
                        </dl>
                    </li>
                    <span class="layui-nav-bar" style="top: 112.5px; height: 0px; opacity: 0;"></span>
                </ul>
            </div>
    </div>
    <!-- 右侧内容 -->
    <div class="layui-body layui-form">
        <div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
            <ul class="layui-tab-title top_tab" id="top_tabs">
                <li class="layui-this" lay-id=""><i class="layui-icon icon-computer">&#xe68e;</i> <cite>后台首页</cite></li>
            </ul>
            <ul class="layui-nav closeBox">
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="layui-icon icon-caozuo">&#xe65f;</i> 页面操作</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" class="refresh refreshThis"><i class="layui-icon">&#x1002;</i> 刷新当前</a></dd>
                        <dd><a href="javascript:;" class="closePageOther"><i class="layui-icon icon-prohibit">&#x1006;</i> 关闭其他</a></dd>
                        <dd><a href="javascript:;" class="closePageAll"><i class="layui-icon icon-guanbi">&#x1007;</i> 关闭全部</a></dd>
                    </dl>
                </li>
            </ul>
            <div class="layui-tab-content clildFrame">
                <div class="layui-tab-item layui-show">
                    <iframe src="/admin/main"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- 底部 -->
    <div class="layui-footer footer">
        <p>copyright @2017 souail</p>
    </div>
</div>

<!-- 移动导航 -->
<div class="site-tree-mobile layui-hide"><i class="layui-icon">&#xe602;</i></div>
<div class="site-mobile-shade"></div>

<script type="text/javascript" src="/layadmin/layui/layui.js"></script>
<script type="text/javascript" src="/layadmin/modul/index/leftNav.js"></script>
<script type="text/javascript" src="/layadmin/modul/index/index.js"></script>
</body>
</html>
