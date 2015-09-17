<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?php echo ($info["idle_name"]); ?></title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
    <script src="/Public/Prop/js/jquery.min.js"></script>
    <script src="/Public/Prop/js/TouchSlide.1.1.js"></script>
    <script src="/Public/Prop/js/pintuer.js"></script>
</head>
<body class="bg">
<header class="clearfix padding bg-white border-bottom">
    <div class="x4">
        <a href="<?php echo U('Prop/Idle/index');?>"><span class="icon-angle-left text-large text-green"></span></a>
    </div>
    <h4 class="x4 height text-center">
        我的闲置
    </h4>
</header>
<section class="margin-top" id="idle_info">
    <div class="form-group text-gray ">
        <?php if(!empty($info["idle_img_list"])): ?><div id="focus" class="focus">
            <div class="hd">
                <ul></ul>
            </div>
            <div class="bd bd2">
                <ul>
                    <?php if(is_array($info["idle_img_list"])): $i = 0; $__LIST__ = $info["idle_img_list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li><img _src="<?php echo ($item); ?>?imageView2/5/w/300/h/200" src="/Public/Prop/images/blank.png" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
        <script type="text/javascript">
            TouchSlide({
                slideCell:"#focus",
                titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
                mainCell:".bd ul",
                effect:"left",
                autoPlay:true,//自动播放
                autoPage:true, //自动分页
                switchLoad:"_src" //切换加载，真实图片路径为"_src"
            });
        </script><?php endif; ?>
    </div>
    <div class="form-group select-group padding-small bg-white  border-bottom border-top margin-top clear">
        <div class="label float-left">
            <label for="idle_name"> 物品名称</label>
        </div>
        <div class="field">
            <?php echo ($info["idle_name"]); ?>
        </div>
    </div>

    <div class="form-group select-group padding-small bg-white border-top margin-top clear">
        <div class="label float-left">
            <label for="idle_original_price"> 原价</label>
        </div>
        <div class="field">
            ￥<?php echo ($info["idle_original_price"]); ?> 元
        </div>
    </div>
    <div class="form-group select-group padding-small bg-white  border-bottom border-top clear">
        <div class="label float-left">
            <label for="idle_present_price"> 现价</label>
        </div>
        <div class="field">
            ￥<?php echo ($info["idle_present_price"]); ?> 元
        </div>
    </div>

    <div class="form-group select-group padding-small bg-white border-bottom border-top margin-top clear">
        <div class="label float-left">
            <label for="idle_description"> 描述</label>
        </div>
        <div class="field">
            <?php echo ($info["idle_description"]); ?>
        </div>
    </div>
    
    <div class="margin-top padding-small-left padding-small-right clearfix form-button">
        <button type="button" class="button x12 bg-green" id="return">返回</button>
    </div>
</section>
<script src="/Public/Admin/js/layer/layer.js"></script>
<script>
$(function(){
	$("#return").click(function(e) {
        window.location.href="<?php echo U('Prop/Idle/index');?>";
    });
});

</script>

</body>
</html>