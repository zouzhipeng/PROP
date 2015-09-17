<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>代注册</title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
    <script src="/Public/Prop/js/jquery.min.js"></script>
</head>
<body class="bg">
<header class="clearfix padding bg-white border-bottom">
    <div class="x4">
        <a href="/"><span class="icon-angle-left text-large text-diy"></span></a>
    </div>
    <h4 class="x4 height text-center">
        代注册
    </h4>
</header>
<section class="margin-top">
    <div class="form-group select-group padding-small bg-white  border-bottom border-top margin-top" style="height:46px; line-height:34px;">
        <div class="label float-left">
            <label for="house">房屋</label>
        </div>
        <div class="field">
            <div class="x4">
                <select class="form-control" name="project_id">
                <?php if(is_array($project_list)): $i = 0; $__LIST__ = $project_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option value="<?php echo ($item["h_id"]); ?>"><?php echo ($item["project"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <div class="x4">
                <select class="form-control" name="building">
                </select>
            </div>
            <div class="x4">
                <select class="form-control" name="room_number">
                </select>
            </div>
        </div>
    </div>
    
    <div class="form-group select-group padding-small bg-white  border-bottom border-top margin-top">
        <div class="label float-left">
            <label for="phone"> 手机号</label>
        </div>
        <div class="field">
            <input type="text" class="input" placeholder="请输入手机号码" name="phone"/>
        </div>
    </div>

    <div class="form-group select-group padding-small bg-white  border-bottom border-top margin-top">
        <div class="label float-left">
            <label for="password"> 设置密码</label>
        </div>
        <div class="field">
            <input type="password" class="input" placeholder="6~12位的数字或字母" name="password"/>
        </div>
    </div>
    <div class="form-group select-group padding-small bg-white  border-bottom">
        <div class="label float-left">
            <label for="confirm_password"> 确认密码</label>
        </div>
        <div class="field">
            <input type="password" class="input" placeholder="重新输入密码" name="confirm_password"/>
        </div>
    </div>
    <div class="form-group select-group padding-small bg-white  border-bottom border-top margin-top">
        <div class="label float-left">
            <label for="confirm_password"> 验证码</label>
        </div>
        <div class="field">
            <input type="text" class="input" style="width:100px; display:inline-block;" placeholder="输入验证码" name="validatecode"/>
            <input type="button" value="获取验证码" class="input" style="width:auto; border:solid 1px #ddd; display:inline-block;" name="get_validatecode">
        </div>
    </div>
    <div class="form-group padding-small">
    * 若用户已存在则设置的密码不会生效
    </div>    
    
    <div class="margin-top padding-small-left padding-small-right clearfix form-button">
        <button type="button" name="submit" class="button x12 bg-diy">提交</button>
    </div>
</section>
<script src="/Public/Admin/js/layer/layer.js"></script>
<script>
var wait_time = 10;
var project_id = $("input[name='project_id']").val();
$(function(){
	$("select[name='project_id']").change(function(e) {
		get_HouseSelect($(this).val(),"");
	});
	
	$("select[name='building']").change(function(e) {
		get_HouseSelect($("select[name='project_id']").val(),$(this).val());
	});
	
	//$("select[name='project_id']").val(project_id);
	$("select[name='project_id']").change();
	//get_HouseSelect();
	
	$("button[name='submit']").click(function(){
		if(!checkFrom()){
			return;
		}
		layer.load(1);
		var user_house_id = $("select[name='house'] option:selected").attr("user_house_id");
		var project_id = $("select[name='project_id']").val();
		var project_name = $("select[name='house'] option:selected").attr("project_name");
		var building = $("select[name='house'] option:selected").attr("building");
		var room_number = $("select[name='house'] option:selected").attr("room_number");
		var phone = $("input[name='phone']").val();
		var password = $("input[name='password']").val();
		var validatecode = $("input[name='validatecode']").val();
		
		$.post("/Prop/Dregister/index/",{
			"user_house_id":user_house_id,
			"project_id":project_id,
			"project_name":project_name,
			"building":building,
			"room_number":room_number,
			"phone":phone,
			"password":password,
			"validatecode":validatecode,
		},
		function(data){
			layer.closeAll('loading');
			if(data.err){
				layer.msg(data.msg, {icon: 0});
			}
			else{
				layer.msg(data.msg);
				//setTimeout("location.reload()",3000);
			}
		},"json");
	});
	
	$("input[name='get_validatecode']").click(function(){
		$(this).attr("disabled","disabled");
		var phone = $("input[name='phone']").val();
		if(phone.length != 11){
			$("input[name='phone']").focus();
			layer.msg("请正确填写手机号！");
			$(this).removeAttr("disabled"); 
			return false;
		}
		
		
		$.post("<?php echo U('/Prop/Index/send_validatecode/');?>",{phone:phone},function(){
		
		});
		setTimeout("wait()",1000);
	});
});

function get_HouseSelect(project_id,building){
	
	$.get("<?php echo C('HOUSE_API.URL');?>",{
		"h_id": project_id,
		"building": building,
	},function(data){
		if(building==""){
			var obj = $("select[name='building']");
			var v = "building";
		}
		else{
			var obj = $("select[name='room_number']");
			var v = "room";
		}
		$(obj).empty();
		
		console.log(data);
		$(data).each(function(index, element) {
			$(obj).append('<option value="'+element[v]+'">'+element[v]+'</option>');
		});
		
		if(project_id==""){
			$("select[name='project_id']").change();
		}
		if(building==""){
			$("select[name='building']").change();
		}
	},"jsonp");	
}


function wait(){
	if(wait_time>0){
		$("input[name='get_validatecode']").val("请等待"+wait_time+"秒后重试");
		wait_time--;
		setTimeout("wait()",1000);
	}
	else{
		wait_time = 10;
		$("input[name='get_validatecode']").val("获取验证码");
		$("input[name='get_validatecode']").removeAttr("disabled"); 
	}
}

function checkFrom(){
	if($("input[name='phone']").val().length != 11){
		$("input[name='phone']").focus();
		layer.msg("请正确填写手机号！");
		return false;
	}
	if($("input[name='password']").val().length < 6){
		$("input[name='password']").focus();
		layer.msg("密码必须为6~12位！");
		return false;
	}
	if($("input[name='password']").val() != $("input[name='confirm_password']").val()){
		$("input[name='password']").focus();
		layer.msg("两次密码输入不一致！");
		return false;
	}
	if($("input[name='validatecode']").val() == ""){
		$("input[name='validatecode']").focus();
		layer.msg("验证码不能为空！");
		return false;
	}
	return true;
}
</script>

</body>
</html>