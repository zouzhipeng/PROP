<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="keywords" content="" />
<meta name="description" content="" />
<title><?php echo ($webname); ?></title>
<script src="/Public/js/jquery.js"></script>
</head>
<body>
<script type="text/javascript">  
    $.getJSON("<?php echo (C("GET_TOKEN")); ?>",  
    function(result) {  
       //alert(result.token);exit;
        if (result.status==1) {
			location.href='/Event/Index/Apilogin?token='+result.token+'&backurl=<?php echo ($backurl); ?>';        	
		}else{		
			location.href='/Event/Index/logint';
		}
        });
</script>
</body>
</html>