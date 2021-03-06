<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>拼车</title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
    <link rel="stylesheet" href="/Public/Prop/iconfont.css">
    <script src="/Public/Prop/js/jquery.min.js"></script>
</head>
<body>
<header class="clearfix padding-top padding-bottom bg text-white border-bottom">
    <div class="x4 padding-left">
        <a href="/Prop/Neighbor/index.html"><span class="icon-angle-left text-large text-diy"></span></a>
    </div>
    <div class="x4 height clearfix">
        <div class="button-group x12 clearfix item-btn">
            <button type="button" class="x6 button button-small  border bg-diy border-white" onclick="tab(this)">路线</button>
            <button type="button" class="x6 button button-small border-diy border" onclick="tab(this)" id="my_list">我的</button>
        </div>
    </div>
    <div class="x4 text-right padding-right height-big">
        <a href="<?php echo U('add_carpool');?>" class="text-diy">发布</a>
    </div>
</header>
<section>
    <div class="item-block">
        <div class="clearfix border-top border-bottom text-center" id="filter">
            <div class="button-group dropdown x6  border-right clearfix" id="filter_type">
                <button type="button" class="button dropdown-toggle x12">类型 <span class="text-gray downward"></span></button>
                <ul class="drop-menu x12">
                    <li><a href="###" class="on" carpool_type="0">所有</a></li>
                    <li><a href="###" carpool_type="1">找车主</a></li>
                    <li><a href="###" carpool_type="2">找乘客</a></li>
                </ul>
            </div>
            <div class="button-group dropdown x6 clearfix" id="filter_time">
                <button type="button" class="button dropdown-toggle x12">时间 <span class="text-gray downward"></span></button>
                <ul class="drop-menu x12">
                    <li><a href="###" class="on" carpool_gotime="0">所有</a></li>
                    <?php if(is_array($filter_time)): $i = 0; $__LIST__ = $filter_time;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li><a href="###" carpool_gotime="<?php echo ($item); ?>"><?php echo ($key); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
        <div class="margin-bottom " id="carpool_list">
        </div>
    </div>

    <div class="item-block hidden">
        <div class="text-center border-top border-bottom clearfix">
            <div class="x6 padding border-right">
                <a href="###">我联系的</a>
            </div>
            <div class="x6 padding">
                <a href="###">我发布的</a>
            </div>
        </div>
        <div id="tabBox" class="tabBox">
            <div id="tabBoxHd" class="hd">
                <h3>
                    <ul class="clearfix">
                    	<li idle_type="1"></li>
                    	<li class="on" id="my_carpool"></li>
                    </ul>
                </h3>
            </div>
            <div class="bd" id="tabBox_main">
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
        商城
    </a>
    <a href="<?php echo U('Prop/My/index');?>" class="x3 text-small">
        <i class="icon iconfont text-diysize2">&#xe616;</i><br/>
        我的
    </a>
</footer>
<script src="/Public/Admin/js/layer/layer.js"></script>
<script>
var last_id = 0;
var do_load = true;
$(function(){
	$("#filter button").click(function(e) {
		$(this).parent().siblings(".dropdown").find("ul").hide();
        $(this).siblings("ul").toggle();
    });
	
	$("#filter a").click(function(e) {
		$("#filter .drop-menu").hide();
		$(this).parents(".dropdown").find("a").removeClass("on");
        $(this).addClass("on");
		$(this).parents(".dropdown").find("button").html($(this).text()+' <span class="text-gray downward"></span>');
		$("#carpool_list").html("");
		show_list(1);
    });
	
	$("#tabBoxHd li").click(function(e) {
		$("#tabBoxHd li").removeClass("on");
		$(this).addClass("on");
		show_my_carpool();
	});
	$(window).scroll(function () {
		if(do_load && $(document).scrollTop()>=($(document).height()-$(window).height())){
			do_load = false;
			if($("button.bg-diy").index()==0){
				show_list();
			}
			else{
				show_my_carpool();
			}			
		}
	});
	<?php if($is_my == 1 ): ?>$('#my_list').click();
	<?php else: ?>
	show_list(0);<?php endif; ?>
});

function show_list(clear){
	var filter_type = $("#filter_type a.on").attr("carpool_type");
	var filter_time = $("#filter_time a.on").attr("carpool_gotime");
	var last_id = 0;
	if($("#carpool_list a").length > 0){
		last_id = $("#carpool_list a:last").attr("carpool_id");
	}
	
	layer.load(1, {shade: false});
	$.get("/Prop/Carpool/carpool_list/",{
		"last_id": last_id,
		"filter_type": filter_type,
		"filter_time": filter_time,
	},function(data){
		layer.closeAll('loading');
		if(clear==1) $("#carpool_list").html("");
		if($.trim(data)!=""){
			do_load = true;
			$("#carpool_list").append(data);
		}
	});
	
}
function show_my_carpool(){
	/*if($("#idle_list a").length > 0){
		last_id = $("#idle_list a:last").attr("idle_id");
	}*/
	var my_last_id = 0;
	if($("#tabBox_main a").length > 0){
		my_last_id = $("#tabBox_main a:last").attr("carpool_id");
	}
	
	if($("#my_carpool").hasClass("on")){
		layer.load(1, {shade: false});
		$.get("/Prop/Carpool/my_carpool/",{
			"last_id": my_last_id,
		},function(data){
			layer.closeAll('loading');
			if($.trim(data)!=""){
				do_load = true;
				$("#tabBox_main").append(data);
			}
		});
	}
	else{
		$("#tabBox_main").html("");
	}
}

function tab(obj){
	if($(obj).index() == 0){
		//do_load = true;	
	}
	else{
		//do_load = false;
		show_my_carpool();
	}
	do_load = true;
	$(obj).addClass('bg-diy border-white').removeClass('border-diy').siblings().addClass('border-diy').removeClass('bg-diy border-white');
	$('.item-block').eq($(obj).index()).removeClass('hidden').siblings('.item-block').addClass('hidden');
}
</script>
</body>
</html>