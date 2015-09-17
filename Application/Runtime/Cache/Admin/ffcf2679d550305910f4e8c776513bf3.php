<?php if (!defined('THINK_PATH')) exit();?><div id="edit_table">
    <div class="form-group">
        <label>图片</label>
        <img class="img-thumbnail" src="<?php echo ($info["carpool_img"]); ?>" style="max-width:400px; max-height:300px;" alt="">
    </div>
    <div class="form-group">
        <label>标题</label>
        <input class="form-control" name="carpool_title" value="<?php echo ($info["carpool_title"]); ?>">
    </div>
    <div class="form-group">
        <label>路线</label>
        <input class="form-control" name="carpool_route" value="<?php echo ($info["carpool_route"]); ?>">
    </div>
    <div class="form-group">
        <label>出发时间</label>
        <input class="form-control" name="carpool_gotime" value="<?php echo ($info["carpool_gotime"]); ?>">
    </div>
    <div class="form-group">
        <label>类型</label>
        <label class="radio-inline">
        	<input type="radio" name="carpool_type" value="1" <?php if($info["carpool_type"] == 1 ): ?>checked="checked"<?php endif; ?>>我有车
        </label>
        <label class="radio-inline">
        	<input type="radio" name="carpool_type" value="2" <?php if($info["carpool_type"] == 2 ): ?>checked="checked"<?php endif; ?>>我无车
        </label>
    </div>
    <div class="form-group">
        <label>状态</label>
        <label class="radio-inline">
        	<input type="radio" name="carpool_state" value="0" <?php if($info["carpool_state"] == 0 ): ?>checked="checked"<?php endif; ?>>未审核
        </label>
        <label class="radio-inline">
        	<input type="radio" name="carpool_state" value="1" <?php if($info["carpool_state"] == 1 ): ?>checked="checked"<?php endif; ?>>已审核
        </label>
        <label class="radio-inline">
        	<input type="radio" name="carpool_state" value="2" <?php if($info["carpool_state"] == 2 ): ?>checked="checked"<?php endif; ?>>已完成
        </label>
        <label class="radio-inline">
        	<input type="radio" name="carpool_state" value="3" <?php if($info["carpool_state"] == 3 ): ?>checked="checked"<?php endif; ?>>已取消
        </label>
    </div>
    <div class="form-group">
        <label>备注</label>
        <textarea class="form-control" name="carpool_remark" rows="3"><?php echo ($info["carpool_remark"]); ?></textarea>
    </div>
    <input type="hidden" name="carpool_id" value="<?php echo ($info["carpool_id"]); ?>">
<button type="submit" name="save" class="btn btn-default">保存</button>
<button type="button" name="close" class="btn btn-sm btn-link pull-right">关闭</button>

<script>
$("#edit_table button[name='close']").click(function(e) {
    layer.closeAll('page');
});
$("#edit_table button[name='save']").click(function(e) {
	layer.load(1, {shade: [0.4,'#000']});
	var carpool_id = $("#edit_table input[name='carpool_id']").val();
	var carpool_title = $("#edit_table input[name='carpool_title']").val();
	var carpool_route = $("#edit_table input[name='carpool_route']").val();
	var carpool_gotime = $("#edit_table input[name='carpool_gotime']").val();
	var carpool_type = $('#edit_table :radio[name="carpool_type"]:checked').val();
	var carpool_state = $('#edit_table :radio[name="carpool_state"]:checked').val();
	var carpool_remark = $("#edit_table textarea[name='carpool_remark']").val();
	$.post("/Admin/Carpool/carpool_edit/",{
		"carpool_id": carpool_id,
		"carpool_title": carpool_title,
		"carpool_route": carpool_route,
		"carpool_gotime": carpool_gotime,
		"carpool_type": carpool_type,
		"carpool_state": carpool_state,
		"carpool_remark": carpool_remark,
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