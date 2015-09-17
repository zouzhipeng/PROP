<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?php echo ($project); ?></title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
    <script src="/Public/Prop/js/jquery.min.js"></script>
</head>
<body>
<header class="clearfix padding-small bg text-white">
    <div class="x2">
        <a href="/"><span class="icon-angle-left text-large text-diy"></span></a>
    </div>
    <div class="x1-move x9 height">
        <div class="button-group x8 item-btn" id="tab">
            <button type="button" class="x6 button button-small border bg-diy border-white">未交费</button>
            <button type="button" class="x6 button button-small border border-diy">账单</button>
        </div>
    </div>
</header>
<section class="border-top">
    <div class="item-block" id="bill_pay">
        <div class="padding clearfix bg-white clearfix border-bottom" onClick="change_house()">
            <div class="float-left">
                <span class="text-large text-gray icon-map-marker margin-small-right height"></span>
                <?php echo ($house["project"]); echo ($house["building"]); ?>栋<?php echo ($house["room_number"]); ?>室
            </div>
            <div class="float-right text-right">
                <span class="text-large text-yellow icon-refresh"></span>切换房屋
            </div>
        </div>
        <div class="margin-top text-center">
            <?php if(empty($bill_list)): ?><div class="no-content">
                <span class="icon-file-text-o text-white"></span>
            </div>        
            <div class="margin-top">
                这里还没有账单!
            </div><?php endif; ?>

			<?php if(is_array($bill_list)): $i = 0; $__LIST__ = $bill_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="padding border-bottom clearfix pay_list">
                <div class="x6 clearfix">
                    <div class="float-left">
                        <input type="checkbox" name="bill_id" value="<?php echo ($item["bill_id"]); ?>"/>
                        <input type="hidden" name="bill_price" value="<?php echo ($item["bill_price"]); ?>"/>
                    </div>
                    <div style="margin-left:18px;">
                        <div><?php echo ($item["bill_title"]); ?></div>
                        <div class="text-gray text-small margin-top"><?php echo ($item["bill_time"]); ?></div>
                    </div>
                </div>
                <div class="x3 text-yellow">￥<?php echo ($item["bill_price"]); ?></div>
                <div class="x3 text-right">
                    <span class="button radius-rounded bg-yellow pay" style="padding: 2px 20px;" bill_id="<?php echo ($item["bill_id"]); ?>">支付</span>
                </div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>

        <footer class="fixed-bottom bg padding clearfix" style="width: 100%">
            <div class="float-left height">
                <span class="text-big">支付</span>
                <span class="text-yellow margin-big-left" id="pay_total">￥0</span>
            </div>
            <div class="float-right text-right">
                <a href="###" class="button radius-rounded bg-yellow pay_all" style="padding: 2px 20px;">支付</a>
            </div>
        </footer>

    </div>
    <div class="item-block" id="bill_list" style="display:none;">
        <div class="padding clearfix bg-white clearfix border-bottom" onClick="change_house()">
            <div class="float-left">
                <span class="text-large text-gray icon-map-marker margin-small-right height"></span>
                <?php echo ($house["project"]); echo ($house["building"]); ?>栋<?php echo ($house["room_number"]); ?>室
            </div>
            <div class="float-right text-right">
                <span class="text-large text-yellow icon-refresh"></span>
            </div>
        </div>
        <div class="padding border-bottom text-gray  date-chose" style="position: relative;">
            <span class="icon-clock-o text-large text-gray margin-small-right"></span>
            <a href="javascript:;" class="height">2015年8月 <span class="margin-little-left icon-down"></span></a>
            <span class="text-large text-gray  margin-small-right margin-big-left icon-angle-right"></span>
            <a href="javascript:;" class="height">2015年11月 <span class="icon-down margin-little-left"></span></a>
        </div>
        <div id="bill_list_content"></div>
    </div>
</section>
</body>
<script src="/Public/Admin/js/layer/layer.js"></script>
<script src="/Public/Prop/js/date.js"></script>
<script>
$(function(){
	var myDate = new Date();
	var m = myDate.getMonth()>1?myDate.getMonth()-1:myDate.getMonth();
	$('.date-chose a').eq(0).html(myDate.getFullYear()+"年"+pad(m+1,	2)+'月<span class="margin-little-left icon-down"></span>');
	$('.date-chose a').eq(1).html(myDate.getFullYear()+"年"+pad(myDate.getMonth()+1,2)+'月<span class="margin-little-left icon-down"></span>');

	
	datebind(function(txt1,txt2){
		//oDate1 = oDate1/1000;
		//oDate2 = oDate2/1000;
		bill_list_bind(txt1,txt2);
	});
	
	refresh_price()
	
	$(".pay_list input[type='checkbox']").click(function(){
		refresh_price();
	});	

	$(".pay_list .pay").click(function(){
		var bill_id = $(this).attr("bill_id");
		confirm_pay(bill_id);
	});
	
	$("#bill_pay .pay_all").click(function(){
		confirm_pay(0);
	});
	
	$("#tab button").click(function(e) {
        $("#tab button").removeClass("bg-diy border-white");
        $("#tab button").removeClass("border-diy");
		$(this).addClass("bg-diy border-white");
		$(this).siblings("button").addClass("border-diy");
		
		if($("#tab button").index($(this)) == 0){
			$("#bill_pay").show(500);
			$("#bill_list").hide(500);
		}
		else{
			$("#bill_pay").hide(500);
			$("#bill_list").show(500);
			var oA1=$('.date-chose').find('a').eq(0);
			var oA2=$('.date-chose').find('a').eq(1);
			var txt1=oA1.text().substring(0,4)+'/'+oA1.text().substring(5,oA1.text().length-1)+"/01";
			m_int = parseInt(oA2.text().substring(5,oA2.text().length-1))+1;
			if(m_int>12)
				var txt2=(parseInt(oA2.text().substring(0,4))+1)+"/01/01";
			else
				var txt2=oA2.text().substring(0,4)+'/'+(parseInt(oA2.text().substring(5,oA2.text().length-1))+1)+"/01";
			//oDate1 = oDate1/1000;
			//oDate2 = oDate2/1000;
			bill_list_bind(txt1,txt2);
		}
    });
}); 

function refresh_price(){
	var total = 0;
	$(".pay_list input[type='checkbox']:checked").each(function(index, element) {
        total += parseFloat($(this).siblings("input[name='bill_price']").val());
    });
	$("#pay_total").html("￥"+total.toFixed(2));
}
function confirm_pay(bill_id){
	var data;
	if(bill_id > 0){
		data = {
			"bill_id": bill_id,
		};
	}
	else{
		var bill_id_arr = new Array();	
		$(".pay_list input[type='checkbox']:checked").each(function(index, element) {
			bill_id_arr.push($(this).val());
		});
		data = {
			"bill_id": bill_id_arr.join(","),
		};
	}
	
	layer.load(1, {shade: [0.4,'#000']});
	$.get("/Prop/Bill/confirm_pay/",data,
	function(data){
		layer.closeAll('loading');
		if(data!=""){
			layer.open({
				type: 1,
				skin: 'layui-layer-rim', //加上边框
				area: '70%', //宽高
				title: '付费详情',
				content: data
			});
		}
	},"html");	
}
function to_pay(bill_id){
	var data;
	if(bill_id > 0){
		data = {
			"bill_id": bill_id,
		};
	}
	else{
		var bill_id_arr = new Array();	
		$(".pay_list input[type='checkbox']:checked").each(function(index, element) {
			bill_id_arr.push($(this).val());
		});
		data = {
			"bill_id": bill_id_arr.join(","),
		};
	}
	
	layer.load(1, {shade: [0.4,'#000']});
	$.get("/Prop/Bill/to_pay/",data,
	function(data){
		layer.closeAll('loading');
		if(data.err){
			layer.msg(data.msg, {icon: 0});
			if(data.err == 2){
				var url = "window.location.href='<?php echo C('RECHARGE_API');?>money="+data.money+"&redirect_url=<?php echo C('DOMAIN');?>/Prop/Bill/to_pay_html/bill_id/"+data.bill_id+"'";
				setTimeout(url,2000);//跳转到支付
			}
		}
		else{
			layer.closeAll('page');
			layer.msg(data.msg);
			location.reload();//页面刷新
		}
	},"json");
}

function bill_list_bind(start_time,end_time){
	
	layer.load(1);
	$("#bill_list #bill_list_content").html("");
	$.post("/Prop/Bill/bill_list/",{
		"start_time":start_time,
		"end_time":end_time,
	},
	function(data){
		layer.closeAll('loading');
		if(data.err){
			layer.msg(data.msg, {icon: 0});
		}
		else{
			$("#bill_list #bill_list_content").html(data.content);
		}
	},"json");
}
function pad(num, n) {
	return Array(n>(''+num).length?(n-(''+num).length+1):0).join(0)+num;  
}  

function change_house(){
	window.location.href = "<?php echo U('change_house');?>";
}
</script>

</html>