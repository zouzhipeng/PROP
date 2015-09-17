<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>发布闲置</title>
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
        发布闲置
    </h4>
</header>
<section class="margin-top">
    <form id="submit_form" method="post" action="<?php echo U('add_idle');?>" enctype="multipart/form-data" onSubmit="return checkFrom()">
    <div class="form-group text-gray ">
        <div class="label margin-small-top padding-left">
            <label for="idle_img">我的闲置</label>
        </div>
        <div class="field padding bg-white  border-bottom border-top up-img-box">
            <div class="up-img" style="display:inline-block;">
                <span class="up-img-btn text-gray">+</span>
                <input type="file" accept="image/*" name="idle_img_1"/>
            </div>
            <div class="up-img" style="display:none;">
                <span class="up-img-btn text-gray">+</span>
                <input type="file" accept="image/*" name="idle_img_2"/>
            </div>
            <div class="up-img" style="display:none;">
                <span class="up-img-btn text-gray">+</span>
                <input type="file" accept="image/*" name="idle_img_3"/>
            </div>
            <div class="up-img" style="display:none;">
                <span class="up-img-btn text-gray">+</span>
                <input type="file" accept="image/*" name="idle_img_4"/>
            </div>
            <div class="up-img" style="display:none;">
                <span class="up-img-btn text-gray">+</span>
                <input type="file" accept="image/*" name="idle_img_5"/>
            </div>
            <div class="margin-small-top text-small">上传闲置图片，会更容易找到小伙伴哦</div>
        </div>
    </div>
    <div class="form-group select-group padding-small bg-white  border-bottom border-top margin-top">
        <div class="label float-left">
            <label for="idle_name"> 物品名称</label>
        </div>
        <div class="field">
            <input type="text" class="input" placeholder="请填写物品名称" name="idle_name"/>
        </div>
    </div>

    <div class="form-group select-group padding-small bg-white border-top margin-top">
        <div class="label float-left">
            <label for="idle_original_price"> 原价</label>
        </div>
        <div class="field">
            <input type="text" class="input input-auto" size="10" placeholder="请输入数字" name="idle_original_price"/>
            元
        </div>
    </div>
    <div class="form-group select-group padding-small bg-white  border-bottom border-top">
        <div class="label float-left">
            <label for="idle_present_price"> 现价</label>
        </div>
        <div class="field">
            <input type="text" class="input input-auto" size="10" placeholder="请输入数字" name="idle_present_price"/>
            元
        </div>
    </div>


    <div class="form-group text-gray ">
        <div class="label margin-small-top padding-left">
            <label for="idle_description">描述</label>
        </div>
        <div class="field bg-white  border-bottom border-top up-img-box">
            <textarea id="" cols="30" rows="2" class="input" placeholder="可以描述闲置物品" name="idle_description"></textarea>
        </div>
    </div>
    <div class="margin-top padding-small-left padding-small-right clearfix form-button">
        <button type="submit" class="button x12 bg-green">发布</button>
    </div>
    </form>
</section>
<script src="/Public/Admin/js/layer/layer.js"></script>
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
				$(file_input).siblings("span").html('<img src="'+this.result+'" width="150" height="150px;">');
			}
		}
		$(this).parent().next().css("display","inline-block");
	});
});

function checkFrom(){
	if($("input[name='idle_name']").val() == ""){
		alert("请输入名字！");
		return false;
	}
	if($("input[name='idle_original_price']").val() == "" || isNaN($("input[name='idle_original_price']").val())){
		alert("请输入原价，必须为数字！");
		return false;
	}
	if($("input[name='idle_present_price']").val() == "" || isNaN($("input[name='idle_present_price']").val())){
		alert("请输入现价，必须为数字！");
		return false;
	}
	return true;
}
</script>

</body>
</html>