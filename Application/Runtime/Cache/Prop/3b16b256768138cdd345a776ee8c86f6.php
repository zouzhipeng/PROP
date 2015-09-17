<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?php echo ($class_name); ?></title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
    <script src="/Public/Prop/js/jquery.min.js"></script>
</head>
<body class="bg">
<header class="clearfix padding bg-white border-bottom">
    <div class="x4">
        <a href="<?php echo U('Prop/Server/index');?>"><span class="icon-angle-left text-large text-diy"></span></a>
    </div>
    <h4 class="x4 height text-center">
        <?php echo ($class_name); ?>
    </h4>
</header>
<section class="margin-top">
    <form id="submit_form" method="post" action="<?php echo U('Prop/Server/serv_post');?>" enctype="multipart/form-data">
    <?php if(is_array($field)): $i = 0; $__LIST__ = $field;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; if($item["field_type"] == 'option' ): ?><div class="form-group select-group padding-small bg-white  border-bottom border-top">
        <div class="label float-left">
            <label for="field_<?php echo ($item["field_id"]); ?>"><?php echo ($item["field_name"]); ?></label>
        </div>
        <div class="field">
            <select name="field_<?php echo ($item["field_id"]); ?>" class="input">
                <?php if(is_array($item['field_option'])): $i = 0; $__LIST__ = $item['field_option'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$option): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($option); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <?php elseif($item["field_type"] == 'img' ): ?>
    <div class="form-group text-gray ">
        <div class="label margin-small-top padding-left">
            <label for="field_<?php echo ($item["field_id"]); ?>"><?php echo ($item["field_name"]); ?></label>
        </div>
        <div class="field padding bg-white  border-bottom border-top up-img-box">
            <div class="up-img">
                <span class="up-img-btn text-gray">+</span>
                <input type="file" name="field_<?php echo ($item["field_id"]); ?>" accept="image/"/>
            </div>
        </div>
    </div>
    <?php elseif($item["field_type"] == 'time' ): ?>
    <div class="form-group text-gray">
        <div class="label margin-small-top padding-left">
            <label for="field_<?php echo ($item["field_id"]); ?>"><?php echo ($item["field_name"]); ?></label>
        </div>
        <div class="field padding-small bg-white  border-bottom border-top date-chose">
            <input type="text" class="input btn-dialog date-input" name="field_<?php echo ($item["field_id"]); ?>" data-val="<?php echo date('Y-m-d',time());?>" value="<?php echo date('Y-m-d',time());?>" placeholder="<?php echo ($item["field_name"]); ?>" flag="3"/>
        </div>
    </div>
    <?php elseif($item["field_type"] == 'text' ): ?>
    <div class="form-group text-gray">
        <div class="label margin-small-top padding-left">
            <label for="field_<?php echo ($item["field_id"]); ?>"><?php echo ($item["field_name"]); ?></label>
        </div>
        <div class="field padding-small bg-white  border-bottom border-top">
            <input type="text" class="input" name="field_<?php echo ($item["field_id"]); ?>" placeholder="<?php echo ($item["field_name"]); ?>" />
        </div>
    </div>
    <?php elseif($item["field_type"] == 'house' ): ?>
    <div class="form-group select-group padding-small bg-white  border-bottom border-top">
        <div class="label float-left">
            <label for="field_<?php echo ($item["field_id"]); ?>"><?php echo ($item["field_name"]); ?></label>
        </div>
        <div class="field">
            <select name="field_<?php echo ($item["field_id"]); ?>" class="input">
                <?php if(is_array($item['field_option'])): $i = 0; $__LIST__ = $item['field_option'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$option): $mod = ($i % 2 );++$i;?><option value="<?php echo ($option['project_name']); echo ($option['building']); ?>(栋)<?php echo ($option['room_number']); ?>号"><?php echo ($option['project_name']); echo ($option['building']); ?>(栋)<?php echo ($option['room_number']); ?>号</option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
    <!--
    <div class="form-group select-group padding-small bg-white  border-bottom border-top">
        <div class="label float-left">
            <label for="">投诉类型</label>
        </div>
        <div class="field">
            <select class="input">
                <option>小区安全</option>
            </select>
        </div>
    </div>
    <div class="form-group text-gray">
        <div class="label margin-small-top padding-left">
            <label for="">投诉详情</label>
        </div>
        <div class="field padding-small bg-white  border-bottom border-top">
            <input type="text" class="input" placeholder="描述投诉内容" autofocus/>
        </div>
    </div>
    <div class="form-group text-gray ">
        <div class="label margin-small-top padding-left">
            <label for="">投诉图片</label>
        </div>
        <div class="field padding bg-white  border-bottom border-top up-img-box">
            <div class="up-img">
                <span class="up-img-btn text-gray">+</span>
                <input type="file" accept="image/"/>
            </div>
			
        </div>
    </div>-->
    <div class="margin-top padding-small-left padding-small-right clearfix form-button">
        <input type="hidden" class="input" name="server_class" value="<?php echo ($server_class); ?>"/>
        <button class="button x12 bg-diy" type="submit">提交</button>
    </div>
    </form>
</section>
</body>
<script src="/Public/Prop/js/dialog.js"></script>
<script>
$(function(){
	$("input[type='file']").on("change", function(){
		var file_input = this;
		// Get a reference to the fileList
		var files = !!this.files ? this.files : [];
		// If no files were selected, or no FileReader support, return
		if (!files.length || !window.FileReader) return;
		// Only proceed if the selected file is an image
		if (/^image/.test( files[0].type)){
			// Create a new instance of the FileReader
			var reader = new FileReader();
			// Read the local file as a DataURL
			reader.readAsDataURL(files[0]);
			// When loaded, set image data as background of div
			reader.onloadend = function(){
				console.log($(file_input).siblings("span"));
				$(file_input).siblings("span").html('<img src="'+this.result+'">');
			}
		}
	});
});
</script>


</html>