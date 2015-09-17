<?php if (!defined('THINK_PATH')) exit();?><div id="edit_table">
    <div class="form-group">
        <label>标题</label>
        <input class="form-control" name="bill_title" value="<?php echo ($info["bill_title"]); ?>">
    </div>
    <div class="form-group clear">
        <label>目标</label>
        <div class="row">
        <div class="col-lg-4">
            <select class="form-control" name="project_id">
            <?php if(is_array($project_list)): $i = 0; $__LIST__ = $project_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option value="<?php echo ($item["h_id"]); ?>" <?php if($item["h_id"] == $info['project_id']): ?>selected="selected"<?php endif; ?>><?php echo ($item["project"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
        <div class="col-lg-4">
            <select class="form-control" name="building">
            </select>
        </div>
        <div class="col-lg-4">
            <select class="form-control" name="room_number">
            </select>
        </div>
        </div>
    </div>
    <div class="form-group">
        <label>订单日期</label>
    	<div class="input-group date form_datetime col-md-5" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
            <input class="form-control" size="16" type="text" name="bill_time" value='<?php echo ($info["bill_time"]); ?>' readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        </div>
    </div>
    <div class="form-group">
        <label>价格</label>
    	<div class="input-group">
            <span class="input-group-addon">￥</span>
            <input type="text" class="form-control" name="bill_price" value="<?php echo ($info["bill_price"]); ?>">
        </div>
    </div>
    <div class="form-group">
        <label>备注</label>
        <textarea class="form-control" name="remarks" rows="3"><?php echo ($info["remarks"]); ?></textarea>
    </div>
    <input class="form-control" type="hidden" name="bill_id" value="<?php echo ($info["bill_id"]); ?>">
<button type="submit" name="save" class="btn btn-default">保存</button>
<button type="button" name="close" class="btn btn-sm btn-link pull-right">关闭</button>

<script>
$(function() {
	$(".form_datetime").datetimepicker({
		format: "yyyy-mm-dd hh:ii",
		language: "zh-CN",
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
		showMeridian: 1
	});
	
	$("#edit_table select[name='project_id']").change(function(e) {
		get_HouseSelect($(this).val(),"");
	});
	
	$("#edit_table select[name='building']").change(function(e) {
		get_HouseSelect($("#edit_table select[name='project_id']").val(),$(this).val());
	});
	
	$("#edit_table select[name='project_id']").change();
	setTimeout('$("#edit_table select[name=\'building\']").val("<?php echo ($info["building"]); ?>");$("#edit_table select[name=\'room_number\']").val("<?php echo ($info["room_number"]); ?>");',1000);
	
	
	$("#edit_table button[name='close']").click(function(e) {
		layer.closeAll('page');
	});
	$("#edit_table button[name='save']").click(function(e) {
		layer.load(1, {shade: [0.4,'#000']});
		var bill_id = $("#edit_table input[name='bill_id']").val();
		var bill_title = $("#edit_table input[name='bill_title']").val();
		var project_id = $("#edit_table select[name='project_id']").val();
		var building = $("#edit_table select[name='building']").val();
		var room_number = $("#edit_table select[name='room_number']").val();
		var bill_time = $("#edit_table input[name='bill_time']").val();
		var bill_price = $("#edit_table input[name='bill_price']").val();
		var remarks = $("#edit_table textarea[name='remarks']").val();
		$.post("/Admin/Bill/bill_edit/",{
			"bill_id": bill_id,
			"bill_title": bill_title,
			"project_id": project_id,
			"building": building,
			"room_number": room_number,
			"bill_time": bill_time,
			"bill_price": bill_price,
			"remarks": remarks,
		},function(data){
			layer.closeAll('loading');
			if(data.err){
				layer.msg(data.msg, {icon: 0});
			}
			else{
				layer.closeAll('page');
				layer.msg(data.msg);
				flash_page();
			}
		},"json");
	});
});

function get_HouseSelect(project_id,building){
	$.get("<?php echo C('HOUSE_API.URL');?>",{
		"h_id": project_id,
		"building": building,
	},function(data){
		if(building==""){
			var obj = $("#edit_table select[name='building']");
			var v = "building";
		}
		else{
			var obj = $("#edit_table select[name='room_number']");
			var v = "room";
		}
		$(obj).empty();
		
		$(data).each(function(index, element) {
			$(obj).append('<option value="'+element[v]+'">'+element[v]+'</option>');
		});
		
		if(building==""){
			$("#edit_table select[name='building']").change();
		}
	},"jsonp");	
}

</script>
</div>