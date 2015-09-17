<?php if (!defined('THINK_PATH')) exit();?><div id="edit_table">
    <div class="form-group">
        <label>图片</label>
        <?php if(is_array($info["idle_img_list"])): $i = 0; $__LIST__ = $info["idle_img_list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><br /><a href="<?php echo ($item); ?>" class="tags" target="_blank"><?php echo ($item); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div class="form-group">
        <label>商品名</label>
        <input class="form-control" name="idle_name" value="<?php echo ($info["idle_name"]); ?>">
    </div>
    <div class="form-group">
        <label>项目</label>
        <label class="radio-inline">
        	<input type="radio" name="idle_type" value="0" <?php if($info["idle_type"] == 0 ): ?>checked="checked"<?php endif; ?>>发布
        </label>
        <label class="radio-inline">
        	<input type="radio" name="idle_type" value="1" <?php if($info["idle_type"] == 1 ): ?>checked="checked"<?php endif; ?>>想买
        </label>
    </div>
    <div class="form-group">
        <label>原价</label>
        <input class="form-control" name="idle_original_price" value="<?php echo ($info["idle_original_price"]); ?>">
    </div>
    <div class="form-group">
        <label>现价</label>
        <input class="form-control" name="idle_present_price" value="<?php echo ($info["idle_present_price"]); ?>">
    </div>
    <div class="form-group">
        <label>状态</label>
        <label class="radio-inline">
        	<input type="radio" name="idle_state" value="0" <?php if($info["idle_state"] == 0 ): ?>checked="checked"<?php endif; ?>>未审核
        </label>
        <label class="radio-inline">
        	<input type="radio" name="idle_state" value="1" <?php if($info["idle_state"] == 1 ): ?>checked="checked"<?php endif; ?>>已审核
        </label>
        <label class="radio-inline">
        	<input type="radio" name="idle_state" value="2" <?php if($info["idle_state"] == 2 ): ?>checked="checked"<?php endif; ?>>已完成
        </label>
        <label class="radio-inline">
        	<input type="radio" name="idle_state" value="3" <?php if($info["idle_state"] == 3 ): ?>checked="checked"<?php endif; ?>>已取消
        </label>
    </div>
    <div class="form-group">
        <label>描述</label>
        <textarea class="form-control" name="idle_description" rows="3"><?php echo ($info["idle_description"]); ?></textarea>
    </div>
    <input type="hidden" name="idle_id" value="<?php echo ($info["idle_id"]); ?>">
<button type="submit" name="save" class="btn btn-default">保存</button>
<button type="button" name="close" class="btn btn-sm btn-link pull-right">关闭</button>

<script>
$('#edit_table a.tags').mouseenter(function(e) {
	layer.tips('<img border="0" src="'+$(this).attr("href")+'?imageView2/5/w/200/h/150" width="100%">',this,{tips:4,area: '200px'}); 
});

$("#edit_table button[name='close']").click(function(e) {
    layer.closeAll('page');
});
$("#edit_table button[name='save']").click(function(e) {
	layer.load(1, {shade: [0.4,'#000']});
	var idle_id = $("#edit_table input[name='idle_id']").val();
	var idle_name = $("#edit_table input[name='idle_name']").val();
	var idle_type = $('#edit_table :radio[name="idle_type"]:checked').val();
	var idle_original_price = $("#edit_table input[name='idle_original_price']").val();
	var idle_present_price = $("#edit_table input[name='idle_present_price']").val();
	var idle_state = $('#edit_table :radio[name="idle_state"]:checked').val();
	var idle_description = $("#edit_table textarea[name='idle_description']").val();
	$.post("/Admin/Idle/idle_edit/",{
		"idle_id": idle_id,
		"idle_name": idle_name,
		"idle_type": idle_type,
		"idle_original_price": idle_original_price,
		"idle_present_price": idle_present_price,
		"idle_state": idle_state,
		"idle_description": idle_description,
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