<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?php echo ($project); ?></title>
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
<header class="clearfix padding bg">
    <div class="x4">
        <a href="javascript:history.go(-1);"><span class="icon-angle-left text-large text-diy"></span></a>
    </div>
    <h4 class="x4 text-center height">
        黄页信息
    </h4>
</header>

<section>
    <?php if(is_array($yellow_list)): $i = 0; $__LIST__ = $yellow_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; if($item["yellow_have_child"] > 0): ?><a href="<?php echo U('index',array('yellow_parent'=>$item['yellow_id']));?>" class="bg-white border-bottom  padding clearfix">
        <div class="x6 height"><?php echo ($item["yellow_name"]); ?><br><?php echo ($item["yellow_address"]); ?></div>
        <div class="x6 text-right">
            <span class="text-gray text-large icon-angle-right"></span>
        </div>
    </a>
    <?php else: ?>
    <a href="tel:<?php echo ($item["yellow_phone"]); ?>" class="bg-white border-bottom  padding clearfix">
        <div class="x10 height-big"><?php echo ($item["yellow_name"]); ?><br><?php echo ($item["yellow_address"]); ?></div>
        <div class="x2 text-right y_middle">
            <span class="text-gray text-large icon-phone text-diy"></span>
        </div>
    </a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
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
        商城
    </a>
    <a href="<?php echo U('Prop/My/index');?>" class="x3 text-small">
        <i class="icon iconfont text-diysize2">&#xe616;</i><br/>
        我的
    </a>
</footer>
</body>
</html>