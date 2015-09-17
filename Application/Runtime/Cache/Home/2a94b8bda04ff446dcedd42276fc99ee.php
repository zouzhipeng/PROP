<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Default Examples</title>
		<style>
			form {
				margin: 0;
			}
			textarea {
				display: block;
			}
		</style>
<link rel="stylesheet" href="/Public/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="/Public/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="/Public/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/Public/kindeditor/jquery-1.9.1.min.js"></script>
<script>
$(function(){
	var editor;
	KindEditor.ready(function(K) {
		editor = K.create('textarea[name="content"]', {
			allowFileManager : true,
			autoHeightMode : true,
			afterCreate : function() {
				this.loadPlugin('autoheight');
			},
			afterUpload : function(url) {
				var firstimageoption = '<option value="' + url + '">' + url + '</option>';
				var selectoption = '<option value="' + url + '" selected="selected">' + url + '</option>';
				$("#firstimage").append(firstimageoption);
				$("#images").append(selectoption);
			}
		});
	});
})
</script>
	</head>
	<body>
		<h3>默认模式</h3>
<form action="<?php echo U('index');?>" method="post">

	标题：<input type="text" name="title" />
	<br />
	内容：<textarea name="content" style="width:800px;height:400px;visibility:hidden;"></textarea>
	<br />
	标题图片：<select type="mutiple" name="firstimage" id="firstimage">
		<option value="">请选择</option>
	</select>
	<br />
	<label for="images" style="display:none">
		<select name="images[]" multiple="multiple" id="images">
	</select></label>
	<input type="submit" value="保存添加" />

</form>
	</body>
</html>