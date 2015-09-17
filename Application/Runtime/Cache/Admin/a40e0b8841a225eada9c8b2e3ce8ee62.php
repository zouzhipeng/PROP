<?php if (!defined('THINK_PATH')) exit();?><div id="add_table">
    <div class="form-group">
        <label>标题</label>
        <input class="form-control" name="notice_title" value="">
    </div>
    <div class="form-group">
        <label>作者</label>
        <input class="form-control" name="notice_author" value="">
    </div>
    <div class="form-group">
        <label>项目</label>
        <select class="form-control" name="project_id">
            <?php if(is_array($project_list)): $i = 0; $__LIST__ = $project_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option value="<?php echo ($item["h_id"]); ?>"><?php echo ($item["project"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
    <div class="form-group">
        <label>置顶</label>
        <label class="radio-inline">
            <input type="radio" name="is_top" value="0" checked="checked">否
        </label>
        <label class="radio-inline">
            <input type="radio" name="is_top" value="1">是
        </label>
    </div>
    <div class="form-group">
        <label>内容</label>
        <textarea class="form-control" name="notice_content" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label>推送至微信：</label><input name="to_wx" type="checkbox" value="1" />*微信规定订阅号每天可推送1次，服务号每天可推送100次，每个用户每月只能接收4条群发消息！
    </div>
    <input type="hidden" name="notice_state" value="1">
<button type="submit" name="draft" class="btn btn-default">保存草稿</button>
<button type="submit" name="save" class="btn btn-default">直接发布</button>
<button type="button" name="close" class="btn btn-sm btn-link pull-right">关闭</button>

<script>
$("#add_table button[name='close']").click(function(e) {
    layer.closeAll('page');
});
$("#add_table button[name='draft']").click(function(e) {
    $("#add_table input[name='notice_state']").val(0);
	$("#add_table button[name='save']").click();
});
$("#add_table button[name='save']").click(function(e) {
	layer.load(1, {shade: [0.4,'#000']});
	var notice_title = $("#add_table input[name='notice_title']").val();
	var notice_author = $("#add_table input[name='notice_author']").val();
	var notice_state = $("#add_table input[name='notice_state']").val();
	var project_id = $("#add_table select[name='project_id']").val();
	var is_top = $('#add_table :radio[name="is_top"]:checked').val();
	var notice_content = $("#add_table textarea[name='notice_content']").val();
	$.post("/Admin/Notice/notice_add/",{
		"notice_title": notice_title,
		"notice_author": notice_author,
		"notice_state": notice_state,
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