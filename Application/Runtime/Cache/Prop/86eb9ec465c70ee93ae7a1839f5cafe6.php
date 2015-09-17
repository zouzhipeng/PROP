<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>我的信息</title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
    <link rel="stylesheet" href="/Public/Prop/iconfont.css">
    <script src="/Public/Prop/js/jquery.min.js"></script>
    <script src="/Public/Prop/js/pintuer.js"></script>
</head>
<style>
a{ position:relative;}
.y_middle{ position:absolute; top:50%; margin-top:-15px; right:10px;}
</style>
<body class="bg">
    <header class="padding bg-diy text-white text-center height clearfix">
        <div class="x4">
            <a href="javascript:history.go(-1);"><span class="icon-angle-left text-large text-diy"></span></a>
        </div>
        <h4 class="x4 text-center height">
            我的信息
        </h4>
    </header>
    <section>
        <div class="border-top" style="text-align:center; margin-bottom:10px;">
        	<img width="100" style="border-radius: 50%; margin-top:5px;" alt="" src="<?php echo session('face');?>">
        </div>
    </section>

    <a href="<?php echo U('Prop/My/my_house');?>#" class="bg-white border-bottom  padding clearfix">
        <div class="x6 height"><i class="icon iconfont">&#xe611;</i> 我的家庭</div>
        <div class="x6 text-right">
            <span class="text-gray text-large icon-angle-right"></span>
        </div>
    </a>
    <a href="<?php echo U('Prop/Idle/index',array('is_my'=>1));?>" class="bg-white border-bottom  padding clearfix">
        <div class="x6 height"><i class="icon iconfont">&#xe631;</i> 我的闲置</div>
        <div class="x6 text-right">
            <span class="text-gray text-large icon-angle-right"></span>
        </div>
    </a>
    <a href="<?php echo U('Prop/Carpool/index',array('is_my'=>1));?>" class="bg-white border-bottom  padding clearfix">
        <div class="x6 height"><i class="icon iconfont">&#xe605;</i> 我的拼车</div>
        <div class="x6 text-right">
            <span class="text-gray text-large icon-angle-right"></span>
        </div>
    </a>
    <a href="<?php echo U('Prop/Bill/index');?>" class="bg-white border-bottom  padding clearfix">
        <div class="x6 height"><i class="icon iconfont">&#xe6a2;</i> 我的账单</div>
        <div class="x6 text-right">
            <span class="text-gray text-large icon-angle-right"></span>
        </div>
    </a>
    <a href="<?php echo U('Prop/Server/index',array('is_my'=>1));?>" class="bg-white border-bottom  padding clearfix">
        <div class="x6 height"><i class="icon iconfont">&#xe62c;</i> 我的服务</div>
        <div class="x6 text-right">
            <span class="text-gray text-large icon-angle-right"></span>
        </div>
    </a>
    <a href="<?php echo U('Prop/Login/logout',array('is_my'=>1));?>" class="bg-white border-bottom  padding clearfix">
        <div class="x6 height"><i class="icon iconfont">&#xe699;</i> 退出登入</div>
        <div class="x6 text-right">
            <span class="text-gray text-large icon-angle-right"></span>
        </div>
    </a>
    <footer class="fixed-bottom clearfix border-top bg padding-small text-center">
        <a href="<?php echo C('DOMAIN');?>" class="x3 text-small">
            <i class="icon iconfont text-diysize2">&#xe611;</i><br/>
            家园
        </a>
        <a href="<?php echo U('Prop/Neighbor/index');?>" class="x3 text-small">
            <i class="icon iconfont text-diysize2">&#xe60c;</i><br/>
            邻里
        </a>
        <a href="http://shop.guanyu.cn" class="x3 text-small">
            <i class="icon iconfont text-diysize2">&#xe68c;</i><br/>
            超市
        </a>
        <a href="<?php echo U('Prop/My/index');?>" class="x3 text-diy text-small">
            <i class="icon iconfont text-diysize2">&#xe675;</i><br/>
            我的
        </a>
    </footer>
</body>
</html>
<?php echo C("STATISTICAL_CODE");?>