<?php if (!defined('THINK_PATH')) exit();?><div id="edit_table">
    <div class="form-group">
        <label>标题</label>
        <input class="form-control" name="notice_title" value="<?php echo ($info["notice_title"]); ?>">
    </div>
    <div class="form-group">
        <label>作者</label>
        <input class="form-control" name="notice_author" value="<?php echo ($info["notice_author"]); ?>">
    </div>
    <div class="form-group">
        <label>项目</label>
        <select class="form-control" name="project_id">
            <?php if(is_array($project_list)): $i = 0; $__LIST__ = $project_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option value="<?php echo ($item["h_id"]); ?>" <?php if($info["project_id"] == $item['h_id']): ?>selected="selected"<?php endif; ?>><?php echo ($item["project"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
    <div class="form-group">
        <label>置顶</label>
        <label class="radio-inline">
            <input type="radio" name="is_top" value="0" <?php if($info["is_top"] == 0): ?>checked="checked"<?php endif; ?>>否
        </label>
        <label class="radio-inline">
            <input type="radio" name="is_top" value="1" <?php if($info["is_top"] == 1): ?>checked="checked"<?php endif; ?>>是
        </label>
    </div>
    <div class="form-group">
        <label>内容</label>
        <textarea class="form-control" name="notice_content" rows="3"><?php echo ($info["notice_content"]); ?></textarea>
    </div>
    <input class="form-control" type="hidden" name="notice_id" value="<?php echo ($info["notice_id"]); ?>">
    <input type="hidden" name="notice_state" value="<?php echo ($info["notice_state"]); ?>">
<button type="submit" name="save" class="btn btn-default">保存</button>
<button type="submit" name="draft" class="btn btn-default">放入草稿箱</button>
<button type="button" name="close" class="btn btn-sm btn-link pull-right">关闭</button>

<script>
$("#edit_table button[name='close']").click(function(e) {
    layer.closeAll('page');
});
$("#edit_table button[name='draft']").click(function(e) {
    $("#edit_table input[name='notice_state']").val(0);
	$("#edit_table button[name='save']").click();
});
$("#edit_table button[name='save']").click(function(e) {
	layer.load(1, {shade: [0.4,'#000']});
	var notice_id = $("#edit_table input[name='notice_id']").val();
	var notice_title = $("#edit_table input[name='notice_title']").val();
	var notice_author = $("#edit_table input[name='notice_author']").val();
	var project_id = $("#edit_table select[name='project_id']").val();
	var is_top = $('#edit_table :radio[name="is_top"]:checked').val();
	var notice_content = $("#edit_table textarea[name='notice_content']").val();
	$.post("/Admin/Notice/notice_edit/",{
		"notice_id": notice_id,
		"notice_title": notice_title,
		"notice_author": notice_author,
		"project_id": project_id,
		"is_top": is_top,
		"notice_content": notice_content,
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

$(function(){
	KindEditor.create('textarea[name="notice_content"]',{afterBlur: function(){this.sync();}});
})
</script>
</div>