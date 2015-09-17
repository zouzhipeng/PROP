<?php if (!defined('THINK_PATH')) exit();?><div id="add_table">
    <div class="form-group">
        <label>名称</label>
        <input class="form-control" name="yellow_name" value="">
    </div>
    <div class="form-group">
        <label>电话</label>
        <input class="form-control" name="yellow_phone" value="">
    </div>
    <div class="form-group">
        <label>描述</label>
        <textarea class="form-control" name="yellow_describe" rows="3"></textarea>
    </div>
    <input name="yellow_parent" type="hidden" value="<?php echo ($yellow_parent); ?>">
    <input name="project_id" type="hidden" value="<?php echo ($project_id); ?>">
<button type="submit" name="save" class="btn btn-default">保存</button>
<button type="button" name="close" class="btn btn-sm btn-link pull-right">关闭</button>

<script>
$("#add_table button[name='close']").click(function(e) {
    layer.closeAll('page');
});
$("#add_table button[name='save']").click(function(e) {
	layer.load(1, {shade: [0.4,'#000']});
	var yellow_name = $("#add_table input[name='yellow_name']").val();
	var yellow_phone = $("#add_table input[name='yellow_phone']").val();
	var project_id = $("#add_table input[name='project_id']").val();
	var yellow_describe = $("#add_table textarea[name='yellow_describe']").val();
	var yellow_parent = $("#add_table input[name='yellow_parent']").val();
	$.post("/Admin/Yellow/yellow_add/",{
		"yellow_name": yellow_name,
		"yellow_phone": yellow_phone,
		"project_id": project_id,
		"yellow_describe": yellow_describe,
		"yellow_parent": yellow_parent,
	},function(data){
		layer.closeAll('loading');
		if(data.err){
			layer.msg(data.msg, {icon: 0});
		}
		else{
			layer.msg(data.msg);

			load_child(yellow_parent,data.rank);
			if(data.rank > 0){
				var parent = $("#rank_"+(data.rank-1)+" a[yellow_id="+yellow_parent+"]");
				if($(parent).hasClass("yellow_edit")){
					$(parent).removeClass("yellow_edit").addClass("yellow_child");
					$(parent).find("i").removeClass("fa-edit").addClass("fa-arrow-right");
					bind_click();
				}
			}
			
			layer.closeAll('page');
		}
	},"json");
});

</script>
</div>