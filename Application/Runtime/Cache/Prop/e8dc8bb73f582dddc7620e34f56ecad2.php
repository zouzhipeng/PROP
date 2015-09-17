<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>闲置</title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
    <link rel="stylesheet" href="/Public/Prop/iconfont.css">
    <script src="/Public/Prop/js/jquery.min.js"></script>
</head>
<body>
<header class="clearfix padding-top padding-bottom bg">
    <div class="x4 padding-left">
        <a href="/Prop/Neighbor/index.html"><span class="icon-angle-left text-large text-diy"></span></a>
    </div>
    <div class="x4 height clearfix">
        <div class="button-group x12 clearfix item-btn">
            <button type="button" class="x6 button button-small  border bg-diy border-white" onclick="tab(this)">市场</button>
            <button type="button" class="x6 button button-small border-diy border" onclick="tab(this)" id="my_list">我的</button>
        </div>
    </div>
    <div class="x4 text-right padding-right height-big">
        我想 <a href="<?php echo U('add_idle');?>" class="text-diy">发布</a> / <a href="<?php echo U('add_buyidle');?>" class="text-diy">要买</a>
    </div>
</header>
<section>
    <div class="item-block">
        <div class="margin-bottom border-top" id="idle_list">
        </div>
    </div>


    <div class="item-block hidden">
        <div class="text-center border-top border-bottom clearfix">
            <div class="x6 padding border-right">
                <a href="" idle_type="1">我想买的</a>
            </div>
            <div class="x6 padding">
                <a href="" idle_type="0">我发布的</a>
            </div>
        </div>
        <div id="tabBox" class="tabBox">
            <div id="tabBoxHd" class="hd">
                <!--<span class="type"></span>-->
                <h3>
                    <ul class="clearfix">
                    	<li idle_type="1"></li>
                    	<li class="on" idle_type="0"></li>
                    </ul>
                </h3>
            </div>
            <div class="bd" id="my_idle">
            </div>
        </div>
    </div>
</section>
<footer class="fixed-bottom clearfix border-top bg padding-small text-center">
    <a href="<?php echo C('DOMAIN');?>" class="x3 text-small">
        <i class="icon iconfont text-diysize2">&#xe611;</i><br/>
        家园
    </a>
    <a href="<?php echo U('Prop/Neighbor/index');?>" class="x3 text-diy text-small">
        <i class="icon iconfont text-diysize2">&#xe663;</i><br/>
        邻里
    </a>
    <a href="http://shop.guanyu.cn" class="x3 text-small">
        <i class="icon iconfont text-diysize2">&#xe68c;</i><br/>
        超市
    </a>
    <a href="<?php echo U('Prop/My/index');?>" class="x3 text-small">
        <i class="icon iconfont text-diysize2">&#xe616;</i><br/>
        我的
    </a>
</footer>
</body>
<script src="/Public/Admin/js/layer/layer.js"></script>
<script>
	var last_id = 0;
	var do_load = true;
	$(function(){
		$("#tabBoxHd li").click(function(e) {
            $("#tabBoxHd li").removeClass("on");
			$(this).addClass("on");
			show_my_idle($(this).attr("idle_type"));
        });
		$(window).scroll(function () {
			if(do_load && $(document).scrollTop()>=($(document).height()-$(window).height())){
				do_load = false;
				append_idle_list();
				
			}
		});
		
		<?php if($is_my == 1 ): ?>$('#my_list').click();
		<?php else: ?>
		append_idle_list();<?php endif; ?>
	});
	
	function append_idle_list(){
		if($("#idle_list a").length > 0){
			last_id = $("#idle_list a:last").attr("idle_id");
		}
		layer.load(1, {shade: false});
		$.get("/Prop/Idle/idle_list/",{
			"last_id": last_id,
		},function(data){
			layer.closeAll('loading');
			if($.trim(data)!=""){
				do_load = true;
				$("#idle_list").append(data);
			}
		});

	}
	
	function show_my_idle(idle_type){
		/*if($("#idle_list a").length > 0){
			last_id = $("#idle_list a:last").attr("idle_id");
		}*/
		layer.load(1, {shade: false});
		$.get("/Prop/Idle/my_idle/",{
			"idle_type": idle_type,
		},function(data){
			if($("#tabBoxHd .on").attr("idle_type") == idle_type){
				layer.closeAll('loading');
				$("#my_idle").html(data);
			}
		});
	}
	
    function tab(obj){
		if($(obj).index() == 0){
			do_load = true;	
		}
		else{
			do_load = false;
			show_my_idle($("#tabBoxHd .on").attr("idle_type"));
		}
        $(obj).addClass('bg-diy border-white').removeClass('border-diy').siblings().addClass('border-diy').removeClass('bg-diy border-white');
        $('.item-block').eq($(obj).index()).removeClass('hidden').siblings('.item-block').addClass('hidden');
    }
</script>
</html>