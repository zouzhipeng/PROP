<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo C("ADMIN_TITLE");?></title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/bootstrap2/bootstrap-switch.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/sb-admin.css" />

    <!-- Custom Fonts -->
    <link rel="stylesheet" type="text/css" href="/Public/Admin/font-awesome/css/font-awesome.min.css" />

    <!-- jQuery -->
    <script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script type="text/javascript" src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script type="text/javascript" src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/admin.css" />
    
    <!-- datetimepicker -->
    <link href="/Public/Admin/js/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">


</head>

<body>
    <div id="wrapper">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    物业管理
                    <?php if(is_array($project_list)): $i = 0; $__LIST__ = $project_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><a class="btn btn-sm <?php if($item["h_id"] == $project_id): ?>btn-success<?php else: ?>btn-default<?php endif; ?>" href="<?php echo U('Admin/Project/index',array('project_id'=>$item['h_id']));?>" bill_id="<?php echo ($item["h_id"]); ?>"><i class="fa fa-building fa-lg"></i> <?php echo ($item["project"]); ?></a>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="<?php echo C('ENTRYDOMAIN');?>" target="_parent">首页</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-cubes"></i> 物业中心
                    </li>
                    <li class="active">
                        <i class="fa fa-briefcase"></i> 物业管理
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-sm-4">
                <div class="list-group" id="Project_menu">
                    <div class="list-group-item active">小区菜单</div>
                    <?php if(is_array($project["project_menu"])): $i = 0; $__LIST__ = $project["project_menu"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><a href="###" class="list-group-item"><?php echo ($item["menu_name"]); ?>
                    <input name="menu_id" type="checkbox" value="<?php echo ($key); ?>" checked></a><?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; if(!isset($project['project_menu'][$item['menu_id']])): ?><a href="###" class="list-group-item"><?php echo ($item["menu_name"]); ?>
                    <input name="menu_id" type="checkbox" value="<?php echo ($item["menu_id"]); ?>"></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="col-sm-4" id="Project_config">
            
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">小区设置</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>物业名称：</label>
                            <input class="form-control" name="project_name" value="<?php echo ($project["project_name"]); ?>">
                            <p class="help-block">物业的全称。</p>
                        </div>
                        <div class="form-group">
                            <label>物业地址：</label>
                            <input class="form-control" name="project_address" value="<?php echo ($project["project_address"]); ?>">
                            <p class="help-block">物业办公办事的地址。</p>
                        </div>
                        <div class="form-group">
                            <label>物业电话：</label>
                            <input class="form-control" name="project_tel" value="<?php echo ($project["project_tel"]); ?>">
                            <p class="help-block">业主联系物业的联系电话。</p>
                        </div>
                        <!--<div class="form-group">
                            <label>主账号：</label>
                            <input class="form-control" name="boss_phone" value="<?php echo ($project["boss_phone"]); ?>">
                            <p class="help-block">物业接受业主信息的账号，如接受业主的账单付款，通常为手机号。</p>
                        </div>-->
                        <button type="submit" name="save" class="btn btn-default">保存</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" id="Project_ad">
            	<form id="submit_form" method="post" action="<?php echo U('Admin/Project/updata_config');?>" enctype="multipart/form-data">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">推广设置</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>好运有礼：</label>
                            <input class="form-control" name="lucky_link" value="<?php echo ($config["lucky_link"]); ?>">
                            <p class="help-block">首页好运有礼的链接。</p>
                        </div>
                        <div class="form-group">
                            <label>新手指南：</label>
                            <input class="form-control" name="novice" value="<?php echo ($config["novice"]); ?>">
                            <p class="help-block">首页新手指南的链接。</p>
                        </div>                        
                        <div class="form-group">
                            <label>幻灯片1：(推荐360*140)</label>
                            <div class="input-group">
                                <span class="input-group-addon">链接：</span>
                                <input class="form-control" name="slides_url_0" value="<?php echo ($config['slides'][0]['url']); ?>">
                            </div>
                            <input type="file" name="slides_file_0"><?php if(!empty($config['slides'][0]['file'])): ?><a href="<?php echo ($config['slides'][0]['file']); ?>" class="tags" target="_blank">查看图片</a> <a href="###">移除</a><input type="hidden" name="is_remove_0" value="0"/><?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label>幻灯片2：(推荐360*140)</label>
                            <div class="input-group">
                                <span class="input-group-addon">链接：</span>
                                <input class="form-control" name="slides_url_1" value="<?php echo ($config['slides'][1]['url']); ?>">
                            </div>
                            <input type="file" name="slides_file_1"><?php if(!empty($config['slides'][1]['file'])): ?><a href="<?php echo ($config['slides'][1]['file']); ?>" class="tags" target="_blank">查看图片</a> <a href="###">移除</a><input type="hidden" name="is_remove_1" value="0"/><?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label>幻灯片3：(推荐360*140)</label>
                            <div class="input-group">
                                <span class="input-group-addon">链接：</span>
                                <input class="form-control" name="slides_url_2" value="<?php echo ($config['slides'][2]['url']); ?>">
                            </div>
                            <input type="file" name="slides_file_2"><?php if(!empty($config['slides'][2]['file'])): ?><a href="<?php echo ($config['slides'][2]['file']); ?>" class="tags" target="_blank">查看图片</a> <a href="###">移除</a><input type="hidden" name="is_remove_2" value="0"/><?php endif; ?>
                        </div>
                        <!--<div class="form-group">
                            <label>主账号：</label>
                            <input class="form-control" name="boss_phone" value="<?php echo ($project["boss_phone"]); ?>">
                            <p class="help-block">物业接受业主信息的账号，如接受业主的账单付款，通常为手机号。</p>
                        </div>-->
                        
                        <input type="hidden" name="project_id" value="<?php echo ($project_id); ?>">
                        <button type="submit" name="save" class="btn btn-default">保存</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /#wrapper -->


    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="/Public/Admin/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/bootstrap-switch.min.js"></script>

    <script type="text/javascript" src="/Public/Admin/js/layer/layer.js"></script>
    
    <!-- datetimepicker -->
    <script type="text/javascript" src="/Public/Admin/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="/Public/Admin/js/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    
    <!--  Sortable 拖拽  -->
	<script type="text/javascript" src="/Public/Admin/js/jquery-ui.min.js" charset="UTF-8"></script>
    
    <script type="text/javascript">
	$(function() {
		$("#Project_menu input:checkbox").bootstrapSwitch();
		$('#Project_menu input:checkbox').on('switchChange.bootstrapSwitch', function (e, state) {
			update_menu();
		});
		
		$('#Project_menu').sortable({
			axis: 'y',
			placeholder: 'list-group-item item-blank', //空白占位符的CSS样式
			revert: true, //被拖拽的元素在返回新位置时，会有一个动画效果
			items: 'a', //指定在排序对象中，哪些元素是可以进行拖拽排序的
			helper: 'original',  //在拖拽元素时，显示一个辅助的元素。可选值：'original', 'clone'
			distance: 30,  //决定至少要在元素上面拖动多少像素后，才正式触发排序动作
			//start: function(event, ui) {console.log("start")},
			//sort: function(event, ui) {console.log("sort")},
			//change: function(event, ui) {console.log("change")},
			//beforeStop: function(event, ui) {console.log("beforeStop")},
			//stop: function(event, ui) {console.log("stop")},
			update: function(event, ui) {console.log("update"),update_menu()},
			//receive: function(event, ui) {console.log("receive")},
			//over: function(event, ui) {console.log("over")},
		});
		$('#Project_menu').disableSelection();
		$('#Project_config button[name="save"]').click(function(e) {
            update_project();
        });
		
		$('a.tags').mouseenter(function(e) {
            layer.tips('<img border="0" src="'+$(this).attr("href")+'?imageView2/5/w/720/h/140" width="100%">',this,{tips:4,area: '200px'}); 
        });
		
	});
	
	function update_menu(){
		var menu_id = new Array();
		var project_id = $("input[name='project_id']").val();
		
		$("#Project_menu input:checkbox:checked").each(function(index, element) {
             menu_id.push($(this).val());
        });
		
		$.post("/Admin/Project/update_menu/",{
			"menu_id": menu_id.join(","),
			"project_id": project_id,
		},function(data){
			if(data.err){
				layer.msg(data.msg, {icon: 0});
				setTimeout("location.reload()",2000);
			}
		},"json");
	}
	function update_project(){
		layer.load(1, {shade: [0.4,'#000']});
		var project_name = $("#Project_config input[name='project_name']").val();
		var project_address = $("#Project_config input[name='project_address']").val();
		var project_tel = $("#Project_config input[name='project_tel']").val();
		var project_id = $("input[name='project_id']").val();
		
		$.post("/Admin/Project/update_project/",{
			"project_name": project_name,
			"project_address": project_address,
			"project_tel": project_tel,
			"project_id": project_id,
		},function(data){
			layer.closeAll('loading');
			if(data.err){
				layer.msg(data.msg, {icon: 0});
			}
			else{
				layer.msg(data.msg);
				layer.closeAll('page');
			}
		},"json");
	}
    </script>


</body>

</html>