/**
 * Created by lingwan on 15/8/14.
 */
function datebind(callback){
	var html = '<div class="mask hidden">';
	html += '</div>';
	html += '<div class="chose-date-dialog hidden">';
	html += '    <div class="head padding bg">2015年8月</div>';
	html += '    <div class="main">';
	html += '        <div class="padding-little-top padding-little-bottom" style="text-align: center;">';
	html += '            <div class="box">';
	html += '                <div class="clearfix">';
	html += '                    <div class="txt radius-small bg text-gray float-left text-large add-year"><i class="icon iconfont text-diysize4 camnpr-rotate-180">&#xe698;</i></div>';
	html += '                    <div class="txt radius-small bg text-gray float-left margin-small-left text-large add-month"><i class="icon iconfont text-diysize4 camnpr-rotate-180">&#xe698;</i></div>';
	html += '                </div>';
	html += '                <div class="padding-small-top padding-small-bottom clearfix text-center">';
	html += '                    <div class="float-left year">2015年</div>';
	html += '                    <div class="float-left month">10月</div>';
	html += '                </div>';
	html += '                <div class="clearfix">';
	html += '                    <div class="txt radius-small bg text-gray float-left text-large minus-year"><i class="icon iconfont text-diysize4">&#xe698;</i></div>';
	html += '                    <div class="txt radius-small bg text-gray float-left margin-small-left text-large minus-month"><i class="icon iconfont text-diysize4">&#xe698;</i></div>';
	html += '                </div>';
	html += '            </div>';
	html += '        </div>';
	html += '    </div>';
	html += '    <div class="foot clearfix bg text-center padding">';
	html += '        <div class="x6 cancel">取消</div>';
	html += '        <div class="x6 sure">确定</div>';
	html += '    </div>';
	html += '</div>';
	
	$('body').append(html);
	
	var flag=false;
	$('.date-chose').find('a').click(function(){
		$('.mask').removeClass('hidden');
		$('.chose-date-dialog').removeClass('hidden');
		var txt=$(this).text();
		var txtY=txt.substring(0,5);
		var txtM=txt.substring(5,txt.length);
		$('.chose-date-dialog').find('.year').empty().text(txtY);
		$('.chose-date-dialog').find('.month').empty().text(txtM);
		$('.chose-date-dialog').find('.head').empty().text(txt);
		if($(this).index()==1){
			flag=true;
		}else{
			flag=false;
		}
	
	});
	$('.chose-date-dialog').find('.cancel').click(function(){
		$(this).parents('.chose-date-dialog').addClass('hidden');
		$('.mask').addClass('hidden');
	});
	$('.chose-date-dialog').find('.sure').click(function(){
		var oA1=$('.date-chose').find('a').eq(0);
		var oA2=$('.date-chose').find('a').eq(1);
		if(flag){
			oA1.html($(this).parents('.chose-date-dialog').find('.head').text()+'<span class="margin-little-left icon-down"></span>');
		}else{
			oA2.html($(this).parents('.chose-date-dialog').find('.head').text()+'<span class="margin-little-left icon-down"></span>');
		}
		var txt1=oA1.text().substring(0,4)+'/'+oA1.text().substring(5,oA1.text().length-1)+"/01";
		m_int = parseInt(oA2.text().substring(5,oA2.text().length-1))+1;
		if(m_int>12)
			var txt2=(parseInt(oA2.text().substring(0,4))+1)+"/01/01";
		else
			var txt2=oA2.text().substring(0,4)+'/'+(parseInt(oA2.text().substring(5,oA2.text().length-1))+1)+"/01";
		var oDate1=new Date(txt1).getTime();
		var oDate2=new Date(txt2).getTime();
		console.log(oDate1);
		console.log(oDate2);
	
		if(oDate1>oDate2){
			alert('开始时间不能大于结束时间');
			return;
		}
		$(this).parents('.chose-date-dialog').addClass('hidden');
		$('.mask').addClass('hidden');
		callback(txt1,txt2);
	});
	$('.chose-date-dialog').find('.add-year').click(function(){
		var txtY=$(this).parents('.chose-date-dialog').find('.year').text();
		var txtYN=parseInt(txtY);
		var txtYS=txtYN+1+'年';
		var headStr=$(this).parents('.chose-date-dialog').find('.head').text();
		var headSY=headStr.substring(4,headStr.length);
		$(this).parents('.chose-date-dialog').find('.head').text(txtYN+1+headSY);
		$(this).parents('.chose-date-dialog').find('.year').text(txtYS);
	});
	$('.chose-date-dialog').find('.add-month').click(function(){
		var txtM=$(this).parents('.chose-date-dialog').find('.month').text();
		var txtMN=parseInt(txtM);
		var txtMS="00"+(txtMN+1);
		txtMS = txtMS.substring(txtMS.length-2,txtMS.length) +'月';
		if((parseInt(txtMN)-1)>=11){
			txtMS='01月';
		}
		var headStr=$(this).parents('.chose-date-dialog').find('.head').text();
		var headSY=headStr.substring(0,5);
		$(this).parents('.chose-date-dialog').find('.head').text(headSY+txtMS);
		$(this).parents('.chose-date-dialog').find('.month').text(txtMS);
	});
	$('.chose-date-dialog').find('.minus-year').click(function(){
		var txtY=$(this).parents('.chose-date-dialog').find('.year').text();
		var txtYN=parseInt(txtY);
		var txtYS=txtYN-1+'年';
		var headStr=$(this).parents('.chose-date-dialog').find('.head').text();
		var headSY=headStr.substring(4,headStr.length);
		$(this).parents('.chose-date-dialog').find('.head').text(txtYN-1+headSY);
		$(this).parents('.chose-date-dialog').find('.year').text(txtYS);
	});
	
	$('.chose-date-dialog').find('.minus-month').click(function(){
		var txtM=$(this).parents('.chose-date-dialog').find('.month').text();
		var txtMN=parseInt(txtM);
		var txtMS="00"+(txtMN-1);
		txtMS = txtMS.substring(txtMS.length-2,txtMS.length) +'月';
		if((parseInt(txtMN)-1)<=0){
			txtMS=12+'月';
		}
		var headStr=$(this).parents('.chose-date-dialog').find('.head').text();
		var headSY=headStr.substring(0,5);
		$(this).parents('.chose-date-dialog').find('.head').text(headSY+txtMS);
		$(this).parents('.chose-date-dialog').find('.month').text(txtMS);
	});
}