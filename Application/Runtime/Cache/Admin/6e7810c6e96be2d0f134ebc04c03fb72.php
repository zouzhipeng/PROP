<?php if (!defined('THINK_PATH')) exit();?><div id="edit_table">
    <div class="form-group">
        <label>名称</label>
        <input class="form-control" name="yellow_name" value="<?php echo ($info["yellow_name"]); ?>">
    </div>
    <div class="form-group">
        <label>电话</label>
        <input class="form-control" name="yellow_phone" value="<?php echo ($info["yellow_phone"]); ?>">
    </div>
    <div class="form-group">
        <label>地址</label>
        <input class="form-control" name="yellow_address" value="<?php echo ($info["yellow_address"]); ?>">
    </div>
    <div class="form-group">
        <label>描述</label>
        <textarea class="form-control" name="yellow_describe" rows="3"><?php echo ($info["yellow_describe"]); ?></textarea>
    </div>
    <input name="yellow_id" type="hidden" value="<?php echo ($info["yellow_id"]); ?>">
<button type="submit" name="save" class="btn btn-default">保存</button>
<button type="button" name="close" class="btn btn-sm btn-link pull-right">关闭</button>

<script>
$("#edit_table button[name='close']").click(function(e) {
    layer.closeAll('page');
});
$("#edit_table button[name='save']").click(function(e) {
	layer.load(1, {shade: [0.4,'#000']});
	var yellow_id = $("#edit_table input[name='yellow_id']").val();
	var yellow_name = $("#edit_table input[name='yellow_name']").val();
	var yellow_phone = $("#edit_table input[name='yellow_phone']").val();
	var yellow_address = $("#edit_table input[name='yellow_address']").val();
	var yellow_describe = $("#edit_table textarea[name='yellow_describe']").val();
	$.post("/Admin/Yellow/yellow_edit/",{
		"yellow_id": yellow_id,
		"yellow_name": yellow_name,
		"yellow_phone": yellow_phone,
		"yellow_address": yellow_address,
		"yellow_describe": yellow_describe,
	},function(data){
		layer.closeAll('loading');
		if(data.err){
			layer.msg(data.msg, {icon: 0});
		}
		else{
			layer.msg(data.msg);
			load_child(data.yellow_parent,data.yellow_rank);
			layer.closeAll('page');
		}
	},"json");
});

</script>
</div>