<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>邻里</title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
    <link rel="stylesheet" href="/Public/Prop/iconfont.css">
    <script src="/Public/Prop/js/jquery.min.js"></script>
    <script src="/Public/Prop/js/pintuer.js"></script>
</head>
<body>
<header class="clearfix padding bg">
    <div class="x4">
        <a href="/"><span class="icon-angle-left text-large text-diy"></span></a>
    </div>
    <h4 class="x4 text-center height">
        邻里邻居
    </h4>
</header>

<section>
    <div class="item-block">
        <div class="clearfix text-center" id="Server_class">
            <a href="/Prop/Idle/index.html" class="x4 padding-big border-right border-bottom">
                <i class="icon iconfont text-diysize text-red">&#xe660;</i>
                <div class="margin-top">闲置</div>
            </a>
            <a href="/Prop/Carpool/index.html" class="x4 padding-big border-right border-bottom">
                <i class="icon iconfont text-diysize text-blue">&#xe64f;</i>
                <div class="margin-top">拼车</div>
            </a>
            <a href="/Prop/Yellow/index.html" class="x4 padding-big border-bottom">
                <i class="icon iconfont text-diysize text-green">&#xe679;</i>
                <div class="margin-top">黄页</div>
            </a>
        </div>
    </div>
</section>
<footer class="fixed-bottom clearfix border-top bg padding-small text-center">
    <a href="<?php echo C('DOMAIN');?>" class="x3 text-small">
        <i class="icon iconfont text-diysize2">&#xe611;</i><br/>
        家园
    </a>
    <a href="<?php echo U('Prop/Neighbor/index');?>" class="x3 text-diy text-small">
        <i class="icon iconfont text-diysize2">&#xe663;</i><br/>
        邻里
    </a>
    <a href="http://shop.guanyu.cn" class="x3 text-small">
        <i class="icon iconfont text-diysize2">&#xe68c;</i><br/>
        超市
    </a>
    <a href="<?php echo U('Prop/My/index');?>" class="x3 text-small">
        <i class="icon iconfont text-diysize2">&#xe616;</i><br/>
        我的
    </a>
</footer>
</body>
</html>