<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?php echo ($info["carpool_title"]); ?></title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
    <script src="/Public/Prop/js/jquery.min.js"></script>
</head>
<body class="bg">
<header class="clearfix padding bg-white border-bottom">
    <div class="x4">
        <a href="<?php echo U('Prop/Idle/index');?>"><span class="icon-angle-left text-large text-green"></span></a>
    </div>
    <h4 class="x4 height text-center">
        拼车信息
    </h4>
</header>
<section class="margin-top" id="idle_info">
    <?php if(!empty($info["carpool_img"])): ?><div class="form-group text-gray ">
        <div class="label margin-small-top padding-left">
            <label for="carpool_img">拼车汽车</label>
        </div>
        <div class="field padding bg-white  border-bottom border-top up-img-box">
            <div class="up-img">
                <span class="up-img-btn text-gray"><img src="<?php echo ($info["carpool_img"]); ?>?imageView2/0/w/400/h/300" alt="" class=""/></span>
            </div>
        </div>
    </div><?php endif; ?>
    <div class="form-group select-group padding-small bg-white  border-bottom border-top margin-top clear">
        <div class="label float-left">
            <label for="carpool_title"> 标题</label>
        </div>
        <div class="field">
            <?php echo ($info["carpool_title"]); ?>
        </div>
    </div>

    <div class="form-group select-group padding-small bg-white border-top margin-top clear">
        <div class="label float-left">
            <label for="carpool_route"> 路线</label>
        </div>
        <div class="field">
            <?php echo ($info["carpool_route"]); ?>
        </div>
    </div>
    <div class="form-group select-group padding-small bg-white  border-bottom border-top clear">
        <div class="label float-left">
            <label for="carpool_gotime"> 出发时间</label>
        </div>
        <div class="field">
            <?php echo ($info["carpool_gotime"]); ?>
        </div>
    </div>

    <div class="form-group select-group padding-small bg-white border-bottom border-top margin-top clear">
        <div class="label float-left">
            <label for="carpool_type"> 拼车类型</label>
        </div>
        <div class="field">
            <?php echo ($info["carpool_type_text"]); ?>
        </div>
    </div>
    
    <div class="margin-top padding-small-left padding-small-right clearfix form-button">
    	<?php if($info["carpool_type"] == 1): ?><button type="button" class="button x12 bg-green" id="call" token="<?php echo session('token');?>" uin="<?php echo session('uin');?>">联系车主</button>
        <?php elseif($info["carpool_type"] == 2): ?>
        <button type="button" class="button x12 bg-green" id="call" token="<?php echo session('token');?>" uin="<?php echo session('uin');?>">联系乘客</button><?php endif; ?>
    </div>
</section>
<script src="/Public/Admin/js/layer/layer.js"></script>
<script>
$(function(){
	$("#call").click(function(e) {
        window.location.href="http://im.guanyu.cn/chart/user.html?my_token="+$(this).attr("token")+"&to_id="+$(this).attr("uin");
    });
});

</script>

</body>
</html>