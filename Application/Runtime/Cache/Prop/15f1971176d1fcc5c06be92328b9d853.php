<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title></title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
    <script src="/Public/Prop/js/jquery.min.js"></script>
</head>
<body>
</body>
<script src="/Public/Admin/js/layer/layer.js"></script>
<script src="/Public/Prop/js/date.js"></script>
<script>
$(function(){
	var bill_id = '<?php echo ($bill_id); ?>';
	to_pay(bill_id);
}); 

function to_pay(bill_id){
	var data;
	data = {
			"bill_id": bill_id,
	};
	
	//layer.load(1, {shade: [0.4,'#000']});
	$.get("/Prop/Bill/to_pay/",data,
	function(data){
		//layer.closeAll('loading');
		if(data.err){
			layer.msg(data.msg, {icon: 0});
		}
		else{
			layer.msg(data.msg);
		}
		
		var url = "window.location.href='<?php echo C('DOMAIN'); echo U('Bill/index');?>'";
		setTimeout(url,2000);//跳转到列表

	},"json");
}
</script>

</html>