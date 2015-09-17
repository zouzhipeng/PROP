<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>服务</title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
    <script src="/Public/Prop/js/jquery.min.js"></script>
    <script src="/Public/Prop/js/pintuer.js"></script>
</head>
<body>
<header class="clearfix padding-top padding-bottom bg border-bottom">
    <div class="x4 padding-left">
        <a href="/"><span class="icon-angle-left text-large text-diy"></span></a>
    </div>
    <div class="x4 height clearfix">
        <div class="button-group x12 clearfix item-btn" id="tab">
            <button type="button" class="x6 button button-small  border bg-diy border-white">服务</button>
            <button type="button" class="x6 button button-small border-diy border" id="my_list">我的</button>
        </div>
    </div>
    <!--<div class="x4 text-right padding-right height-big">
        <a href="" class="text-diy">发布</a>
    </div>-->
</header>
<section>
    <div class="item-block">
        <div class="clearfix text-center" id="Server_class">
            <a href="<?php echo U('Prop/Server/serv_post/server_class/1');?>" class="x4 padding-big border-right border-bottom">
                <span class="icon-service text-blue icon-phone"></span>
                <div class="margin-top">投诉建议</div>
            </a>
            <a href="<?php echo U('Prop/Server/serv_post/server_class/2');?>" class="x4 padding-big border-right border-bottom">
                <span class="icon-service text-blue icon-wrench"></span>
                <div class="margin-top">维修报障</div>
            </a>
            <a href="<?php echo U('Prop/Server/serv_post/server_class/3');?>" class="x4 padding-big border-bottom">
                <span class="icon-service text-blue icon-gavel"></span>
                <div class="margin-top">施工申请</div>
            </a>
        </div>
    </div>
    <div class="item-block text-center" style="display:none;" id="Server_list">
        <div class="no-content">
            <span class="icon-file-text-o text-white"></span>
        </div>        
        <div class="margin-top">
            这里还没有纪录!
        </div>
    </div>
</section>
<script src="/Public/Admin/js/layer/layer.js"></script>
<script>
$(function(){
	$("#tab button").click(function(e) {
        $("#tab button").removeClass("bg-diy border-white");
        $("#tab button").removeClass("border-diy");
		$(this).addClass("bg-diy border-white");
		$(this).siblings("button").addClass("border-diy");
		
		if($("#tab button").index($(this)) == 0){
			$("#Server_class").show(500);
			$("#Server_list").hide(500);
		}
		else{
			$("#Server_class").hide(500);
			$("#Server_list").show(500);
			Server_list_bind();
		}
		
    });
	<?php if($is_my == 1 ): ?>$('#my_list').click();<?php endif; ?>
});

function Server_list_bind(){
	layer.load(1);
	$.post("/Prop/Server/serv_list/",{
	},
	function(data){
		layer.closeAll('loading');
		if(data.err){
			layer.msg(data.msg, {icon: 0});
		}
		else{
			if(data.content!=""){
				$("#Server_list").html(data.content);
			}
		}
	},"json");
}
</script>
</body>
</html>