<?php if (!defined('THINK_PATH')) exit();?><div id="view_table" class="clear">
    <?php if(is_array($field)): $i = 0; $__LIST__ = $field;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; if($item["field_type"] == 'option' ): ?><div class="form-group">
        <label><?php echo ($item["field_name"]); ?></label>
        <input class="form-control" value="<?php echo ($item["value"]); ?>" readonly="readonly">
    </div>
    <?php elseif($item["field_type"] == 'img' ): ?>
    <div class="form-group">
        <div><label><?php echo ($item["field_name"]); ?></label></div>
        <img class="img-thumbnail" src="<?php echo ($item["value"]); ?>" alt="">
    </div>
    <?php elseif($item["field_type"] == 'time' ): ?>
    <div class="form-group">
        <label><?php echo ($item["field_name"]); ?></label>
        <input class="form-control" value="<?php echo ($item["value"]); ?>" readonly="readonly">
    </div>
    <?php elseif($item["field_type"] == 'text' ): ?>
    <div class="form-group">
        <label><?php echo ($item["field_name"]); ?></label>
        <input class="form-control" value="<?php echo ($item["value"]); ?>" readonly="readonly">
    </div>
    <?php elseif($item["field_type"] == 'house' ): ?>
    <div class="form-group">
        <label><?php echo ($item["field_name"]); ?></label>
        <input class="form-control" value="<?php echo ($item["value"]); ?>" readonly="readonly">
    </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
    <div class="form-group">
        <label>状态</label>
        <label class="radio-inline">
        	<input type="radio" name="server_state" value="0" <?php if($info["server_state"] == 0 ): ?>checked="checked"<?php endif; ?>>未审核
        </label>
        <label class="radio-inline">
        	<input type="radio" name="server_state" value="1" <?php if($info["server_state"] == 1 ): ?>checked="checked"<?php endif; ?>>已联系
        </label>
        <label class="radio-inline">
        	<input type="radio" name="server_state" value="2" <?php if($info["server_state"] == 2 ): ?>checked="checked"<?php endif; ?>>已分派
        </label>
        <label class="radio-inline">
        	<input type="radio" name="server_state" value="3" <?php if($info["server_state"] == 3 ): ?>checked="checked"<?php endif; ?>>已完成
        </label>
    </div>
    <input type="hidden" name="server_id" value="<?php echo ($info["server_id"]); ?>">
<button type="submit" name="save" class="btn btn-default">保存</button>
<button type="button" name="close" class="btn btn-sm btn-link pull-right">关闭</button>

<script>
$(function() {
	$("#view_table button[name='close']").click(function(e) {
		layer.closeAll('page');
	});
	//$("#is_read_<?php echo ($server_id); ?>").html('<i class="fa fa-check fa-lg text-success"></i>已读');
});
$("#view_table button[name='save']").click(function(e) {
	layer.load(1, {shade: [0.4,'#000']});
	var server_id = $("#view_table input[name='server_id']").val();
	var server_state = $('#view_table :radio[name="server_state"]:checked').val();
	$.post("/Admin/Server/serv_edit/",{
		"server_id": server_id,
		"server_state": server_state,
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


</script>
</div>