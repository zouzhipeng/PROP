<?php

function err_alert($msg,$url = ""){
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title></title>
    <script src="/Public/Prop/js/jquery.min.js"></script>
    <script src="/Public/Admin/js/layer/layer.js"></script>
</head>
<body>
</body>
<script>
$(function(){
	//墨绿深蓝风
	layer.alert('<?php echo($msg);?>', {
		skin: 'layui-layer-molv' //样式类名
	}, function(){
<?php
	if(empty($url)){
		echo("history.go(-1)");
	}
	else{
		echo("window.location.href='".$url."';");
	}
?>
	});
});
</script>
</html>
<?php
	/* header('Content-Type:text/html;charset=utf-8');
	echo("<script type='text/javascript'>");
	echo("alert('".$msg."');");
	if(empty($url)){
		echo("history.go(-1)");
	}
	else{
		echo("window.location.href='".$url."';");
	}
	echo("</script>"); */
	exit();
}