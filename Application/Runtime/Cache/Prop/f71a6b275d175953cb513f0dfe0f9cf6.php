<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?php echo ($project); ?></title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
</head>
<body>
<header class="clearfix padding bg border-bottom">
    <div class="x4">
        <a href="<?php echo U('Index/index');?>"><span class="icon-angle-left text-large text-green"></span></a>
    </div>
    <h4 class="x4 text-center height">
        通知
    </h4>
</header>
<section class="margin-small-top">
    <div class="border-top">
		<?php if(is_array($notice_list)): $i = 0; $__LIST__ = $notice_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="clearfix padding bg-white border-bottom">
            <a href="<?php echo U('Prop/Notice/info',array('notice_id'=>$item['notice_id']));?>" class="x12">
                <h5><?php echo ($item["notice_title"]); ?></h5>
                <div class="text-small text-gray margin-small-top"><?php echo (date("Y-m-d h:s",$item["add_time"])); ?></div>
                <?php if($item["is_top"] == 1): ?><div class="text-white ding">
                    <span>顶</span>
                </div><?php endif; ?>
            </a>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</section>
</body>
</html>