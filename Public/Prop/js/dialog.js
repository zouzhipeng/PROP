/**
 * Created by lingwan on 15/8/20.
 */
$(function(){
	var html = '<div class="mask hidden">';
	html += '</div>';
	html += '<div class="chose-date-dialog  chose-dialog hidden">';
	html += '    <div class="head padding bg">2015年8月</div>';
	html += '    <div class="main">';
	html += '        <div class="padding-little-top padding-little-bottom text-center">';
	html += '            <div class="box">';
	html += '                <div class="clearfix text-center">';
	html += '                    <div class="float-left ">';
	html += '                        <div class="txt radius-small bg text-gray text-large add" attr="year"><i class="icon iconfont text-diysize4 camnpr-rotate-180">&#xe698;</i></div>';
	html += '                        <div class="year padding-small-top padding-small-bottom">2015年</div>';
	html += '                        <div class="txt radius-small bg text-gray text-large minus" attr="year"><i class="icon iconfont text-diysize4">&#xe698;</i></div>';
	html += '                    </div>';
	html += '                    <div class="float-left margin-small-left">';
	html += '                        <div class="txt radius-small bg text-gray text-large add" attr="month"><i class="icon iconfont text-diysize4 camnpr-rotate-180">&#xe698;</i></div>';
	html += '                        <div class="month padding-small-top padding-small-bottom">10月</div>';
	html += '                        <div class="txt radius-small bg text-gray text-large minus" attr="month"><i class="icon iconfont text-diysize4">&#xe698;</i></div>';
	html += '                    </div>';
	html += '                    <div class="float-left margin-small-left">';
	html += '                        <div class="txt radius-small bg text-gray text-large add" attr="day"><i class="icon iconfont text-diysize4 camnpr-rotate-180">&#xe698;</i></div>';
	html += '                        <div class="day padding-small-top padding-small-bottom">10日</div>';
	html += '                        <div class="txt radius-small bg text-gray text-large minus" attr="day"><i class="icon iconfont text-diysize4">&#xe698;</i></div>';
	html += '                    </div>';
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
	
	var this_obj;

    function dateInit(obj){
		this_obj = obj;

        curDate=$(obj).data('val');
        dateArr=curDate.split('-');
        curYear=dateArr[0];
        curMonth=dateArr[1];
        curDay=dateArr[2];
        curHour=dateArr[3];
        curMin=dateArr[4];
        curSec=dateArr[5];
        $('.chose-dialog').find('.head').text(curYear+'年'+curMonth+'月');
        if(curDay){
            $('.chose-dialog').find('.head').text(curYear+'年'+curMonth+'月'+curDay+'日');
        }

        if($('.chose-date-dialog').find('.year')){
            $('.chose-date-dialog').find('.year').text(curYear+'年');
        }
        if($('.chose-date-dialog').find('.month')){
            $('.chose-date-dialog').find('.month').text(curMonth+'月');
        }
        if($('.chose-date-dialog').find('.day')){
            $('.chose-date-dialog').find('.day').text(curDay+'日');
        }
        if($('.chose-date-dialog').find('.hour')){
            $('.chose-date-dialog').find('.hour').text(curHour+'年');
        }
        if($('.chose-date-dialog').find('.min')){
            $('.chose-date-dialog').find('.min').text(curMin+'分');
        }
        if($('.chose-date-dialog').find('.sec')){
            $('.chose-date-dialog').find('.sec').text(curSec+'秒');
        }
        year=parseInt($('.chose-date-dialog').find('.year').text());
        month=parseInt($('.chose-date-dialog').find('.month').text());
        day=parseInt($('.chose-date-dialog').find('.day').text());
        hour=parseInt($('.chose-date-dialog').find('.hour').text());
        min=parseInt($('.chose-date-dialog').find('.min').text());
        sec=parseInt($('.chose-date-dialog').find('.sec').text());
    }
    function dateCompare(date1,date2){
        var d1=new Date(date1).getTime();
        var d2=new Date(date2).getTime();
        if(d2-d1<0){
            alert('结束时间需大于开始时间');
            return false;
        }else{
            return true;
        }
    }
    $('.btn-dialog').click(function(){
        $('.mask').removeClass('hidden');
        $('.chose-date-dialog').removeClass('hidden');
        flag=$(this).attr('flag');
        dateInit($(this));
    });
    $('.date-input').blur(function(){
        $('.mask').removeClass('hidden');
        $('.chose-date-dialog').removeClass('hidden');
        flag=$(this).attr('flag');
        dateInit($(this));
    });
    $('.add').click(function(){
        var date=$(this).attr('attr');
        switch(date){
            case 'year':
                year++;
                $(this).next().text(year+'年');break;
            case 'month':
                month++;
                if(month>12) month=1;
                $(this).next().text(month+'月');break;
            case 'day':
                day++;
                if(day>31) day=1;
                $(this).next().text(day+'日');break;
            case 'hour':
                hour++;
                if(hour>23) hour=0;
                $(this).next().text(hour+'时');break;
            case 'min':
                min++;
                if(min>60) min=0;
                $(this).next().text(min+'分');break;
            case 'sec':
                sec++;
                $(this).next().text(sec+'秒');break;
        }
        if(day){
            $('.chose-dialog').find('.head').text(year+'年'+month+'月'+day+'日');
            //$('.btn-dialog').data('val',year+'-'+month+'-'+day);
        }else{
            $('.chose-dialog').find('.head').text(year+'年'+month+'月');
            //$('.btn-dialog').data('val',year+'-'+month);
        }

    });
    $('.minus').click(function(){
        var date=$(this).attr('attr');
        switch(date){
            case 'year':
                year--;
                $(this).prev().text(year+'年');break;
            case 'month':
                month--;
                if(month<1) month=12;
                $(this).prev().text(month+'月');break;
            case 'day':
                day--;
                if(day<1) day=31;
                $(this).prev().text(day+'日');break;
            case 'hour':
                hour--;
                if(hour<0) hour=23;
                $(this).prev().text(hour+'时');break;
            case 'min':
                min--;
                if(min<1) min=60;
                $(this).prev().text(min+'分');break;
            case 'sec':
                sec--;
                if(sec<1) sec=60;
                $(this).prev().text(sec+'秒');break;
        }
        if(day){
            $('.chose-dialog').find('.head').text(year+'年'+month+'月'+day+'日');
            //$('.btn-dialog').data('val',year+'-'+month+'-'+day);
        }else{
            $('.chose-dialog').find('.head').text(year+'年'+month+'月');
            //$('.btn-dialog').data('val',year+'-'+month);
        }
    });
    $('.chose-date-dialog').find('.cancel').click(function(){
        $('.mask').addClass('hidden');
        $('.chose-date-dialog').addClass('hidden');
    });
    $('.chose-date-dialog').find('.sure').click(function(){
        if(day){
            var a1=$('.btn-dialog').eq(0).data('val');
            var a1=$('.btn-dialog').eq(1).data('val');
        }else{
            var a1=$('.btn-dialog').eq(0).text();
            var a2=$('.btn-dialog').eq(1).text();        }

        if(flag=='2'){
            if(day){
                var date1=a1;
                var date2=year+'-'+month+'-'+day;
            }else{
                var date1=a1.substring(0,4)+'-'+a1.substring(5,a1.length-1);
                var date2=year+'-'+month;
            }

        }
        if(flag=='1'){
            if(day){
                var date1=year+'-'+month+'-'+day;
                var date2=a2;
            }else{
                var date1=year+'-'+month;
                var date2=a2.substring(0,4)+'-'+a2.substring(5,a2.length-2);
            }

        }
        var bool=dateCompare(date1,date2);
		//var bool=true;
        if(!bool){
            return;
        }else{
            $('.mask').addClass('hidden');
            $('.chose-date-dialog').addClass('hidden');
            if(flag=='1'){
                $('.btn-dialog').eq(0).text(year+'年'+month+'月');
                $('.date-input').eq(0).val(year+'-'+month+'-'+day);
            }
            if(flag=='2'){
                $('.btn-dialog').eq(1).text(year+'年'+month+'月');
                $('.date-input').eq(1).val(year+'-'+month+'-'+day);
            }
			else{
                $(this_obj).text(year+'年'+month+'月');
                $(this_obj).val(year+'-'+month+'-'+day);
			}
        }

    });
});
