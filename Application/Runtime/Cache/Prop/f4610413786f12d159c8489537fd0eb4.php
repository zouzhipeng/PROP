<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>发布拼车</title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
    <script src="/Public/Prop/js/jquery.min.js"></script>
</head>
<body class="bg">
<header class="clearfix padding bg-white border-bottom">
    <div class="x4">
        <a href="<?php echo U('Prop/Carpool/index');?>"><span class="icon-angle-left text-large text-green"></span></a>
    </div>
    <h4 class="x4 height text-center">
        发布拼车
    </h4>
</header>
<section class="margin-top">
    <form id="submit_form" method="post" action="<?php echo U('add_carpool');?>" enctype="multipart/form-data" onSubmit="return checkFrom()">
    <div class="form-group text-gray ">
        <div class="label margin-small-top padding-left">
            <label for="carpool_img">我的汽车</label>
        </div>
        <div class="field padding bg-white  border-bottom border-top up-img-box">
            <div class="up-img">
                <span class="up-img-btn text-gray">+</span>
                <input type="file" accept="image/" name="carpool_img"/>
            </div>
            <div class="margin-small-top text-small">上传爱车照片，会更容易找到拼车小伙伴哦</div>
        </div>
    </div>
    <div class="form-group select-group padding-small bg-white  border-bottom border-top margin-top">
        <div class="label float-left">
            <label for="carpool_title"> 标题</label>
        </div>
        <div class="field">
            <input type="text" class="input" placeholder="请填写标题" name="carpool_title"/>
        </div>
    </div>
    
    <div class="form-group select-group padding-small bg-white  border-bottom border-top margin-top">
        <div class="label float-left">
            <label for="carpool_route"> 起点</label>
        </div>
        <div class="field">
            <input type="text" class="input" placeholder="请填写起点地名" name="carpool_start"/>
        </div>
    </div>
    <div class="form-group select-group padding-small bg-white  border-bottom border-top">
        <div class="label float-left">
            <label for="carpool_route"> 途径</label>
        </div>
        <div class="field">
            <input type="text" class="input" placeholder="请填写途径路线" name="carpool_route"/> 
        </div>
    </div>
    <div class="form-group select-group padding-small bg-white  border-bottom border-top">
        <div class="label float-left">
            <label for="carpool_route"> 终点</label>
        </div>
        <div class="field">
            <input type="text" class="input" placeholder="请填写终点地名" name="carpool_end"/>
        </div>
    </div>
  
    <div class="form-group select-group padding-small bg-white  border-bottom border-top margin-top">
          <div class="label float-left">
            <label for="carpool_gotime">出发时间</label>
        </div>
        <div class="field">
            <input type="text" class="input btn-dialog date-input" name="carpool_gotime" data-val="<?php echo date('Y-m-d H:i',time());?>" value="<?php echo date('Y-m-d H:i',time());?>" placeholder="输入出发时间" flag="4"/>
        </div>
    </div>
    
    <div class="form-group select-group padding-small bg-white  border-bottom border-top margin-top">
        <div class="label float-left">
            <label for="carpool_type">拼车类型</label>
        </div>
        <div class="field">
            <select name="carpool_type" class="input">
                <option value="1">我有车 愿意载人一程</option>
                <option value="2">我没车 希望有人载我一程</option>
            </select>
        </div>
    </div>


    <div class="form-group text-gray ">
        <div class="label margin-small-top padding-left">
            <label for="idle_description">留言</label>
        </div>
        <div class="field bg-white  border-bottom border-top up-img-box">
            <textarea id="carpool_remark" cols="30" rows="2" class="input" placeholder="可以写途径地和对小伙伴的要求" name="carpool_remark"></textarea>
        </div>
    </div>
    <div class="margin-top padding-small-left padding-small-right clearfix form-button">
        <button type="submit" class="button x12 bg-green">发布</button>
    </div>
    </form>
</section>
<script src="/Public/Admin/js/layer/layer.js"></script>
<script src="/Public/Prop/js/dialog2.js"></script>
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

function checkFrom(){
	if($("input[name='carpool_title']").val() == ""){
		alert("请填写标题！");
		return false;
	}
	/*if($("input[name='carpool_route']").val() == ""){
		alert("请填写路线！");
		return false;
	}*/
	if($("input[name='carpool_gotime']").val() == ""){
		alert("请填写出发时间！");
		return false;
	}
	return true;
}
</script>

</body>
</html>