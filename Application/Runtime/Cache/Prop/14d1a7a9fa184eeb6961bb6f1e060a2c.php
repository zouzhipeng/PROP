<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>我的家庭</title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
    <script src="/Public/Prop/js/jquery.min.js"></script>
    <script src="/Public/Prop/js/pintuer.js"></script>
</head>
<body class="bg">
<div class="clearfix padding bg-white border-bottom">
    <div class="x4">
        <a href="<?php echo U('Prop/My/index');?>"><span class="icon-angle-left text-large text-diy"></span></a>
    </div>
    <h4 class="x4 text-center height">
        我的家庭
    </h4>
</div>
<?php if(is_array($house_list)): $i = 0; $__LIST__ = $house_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><a href="###" class="bg-white border-bottom  padding clearfix margin-small-top border-top chose-house">
    <div class="x10 height"><?php echo ($item["project_name"]); echo ($item["building"]); ?>(栋)<?php echo ($item["room_number"]); ?>号</div>
    <div class="x2 text-right padding-small-top hidden check">
        <span class="text-gray text-big icon-check text-diy "></span>
    </div>
</a><?php endforeach; endif; else: echo "" ;endif; ?>
</body>
<script>
//    $('.chose-house').click(function(){
//        $(this).find('.check').removeClass('hidden');
//    });
</script>
</html>