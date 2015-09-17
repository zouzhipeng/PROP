<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?php echo ($info["notice_title"]); ?></title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
</head>
<body class="bg">
<header class="clearfix padding text-gray border-bottom">
    <div class="x4">
        <a href="javascript:history.go(-1);" class="text-large text-green icon-angle-left"></a>
    </div>
</header>
<article class="padding">
    <div class="border-bottom">
        <h4><?php echo ($info["notice_title"]); ?></h4>
        <div class="text-gray margin-top margin-little-bottom"><?php echo ($info["add_time"]); ?></div>
    </div>
    <div class="margin-top">
		<?php echo ($info["notice_content"]); ?>
    </div>
</article>
</body>
</html>