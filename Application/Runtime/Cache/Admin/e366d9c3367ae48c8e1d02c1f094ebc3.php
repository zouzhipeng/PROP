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

</head>

<body>
    <div id="wrapper">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    黄页信息
                    <?php if(is_array($project_list)): $i = 0; $__LIST__ = $project_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><a class="btn btn-sm <?php if($item["h_id"] == $project_id): ?>btn-success<?php else: ?>btn-default<?php endif; ?>" id="bill_add" href="<?php echo U('Admin/Yellow/index',array('project_id'=>$item['h_id']));?>" bill_id="<?php echo ($item["h_id"]); ?>"><i class="fa fa-building fa-lg"></i> <?php echo ($item["project"]); ?></a>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="<?php echo C('ENTRYDOMAIN');?>" target="_parent">首页</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-cubes"></i> 物业中心
                    </li>
                    <li class="active">
                        <i class="fa fa-book"></i> 黄页信息
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="row" id="yellow_menu">
            <div class="col-sm-4" id="rank_0">
                <div class="list-group">
                    <div class="list-group-item active">
                    一级目录
                    <a class="btn btn-xs btn-danger pull-right rank_yellow_del" id="rank_0_del" rank="0" href="###"><i class="fa fa-trash-o"></i> 删除</a>
                    <a class="btn btn-xs btn-info pull-right rank_yellow_edit" id="rank_0_edit" rank="0" href="###"><i class="fa fa-edit"></i> 编辑</a>
                    <a class="btn btn-xs btn-success pull-right rank_yellow_add" id="rank_0_add" rank="0" href="###"><i class="fa fa-plus"></i> 添加</a>
                    </div>
                    <?php if(is_array($rank_0)): $i = 0; $__LIST__ = $rank_0;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; if($item["yellow_have_child"] > 0): ?><a href="###" class="list-group-item yellow_child" yellow_id="<?php echo ($item["yellow_id"]); ?>"><?php echo ($item["yellow_name"]); ?><i class="fa fa-lg fa-arrow-right pull-right"></i></a>
                    <?php else: ?>
                    <a href="###" class="list-group-item yellow_edit" yellow_id="<?php echo ($item["yellow_id"]); ?>"><?php echo ($item["yellow_name"]); ?><i class="fa fa-lg fa-edit pull-right"></i></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="col-sm-4" id="rank_1">
                <div class="list-group">
                    <div class="list-group-item active">
                    二级目录
                    <a class="btn btn-xs btn-danger pull-right rank_yellow_del" id="rank_1_del" rank="1" href="###"><i class="fa fa-trash-o"></i> 删除</a>
                    <a class="btn btn-xs btn-info pull-right rank_yellow_edit" id="rank_1_edit" rank="1" href="###"><i class="fa fa-edit"></i> 编辑</a>
                    <a class="btn btn-xs btn-success pull-right rank_yellow_add" id="rank_1_add" rank="1" href="###"><i class="fa fa-plus"></i> 添加</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" id="rank_2">
                <div class="list-group">
                    <div class="list-group-item active">
                    三级目录
                    <a class="btn btn-xs btn-danger pull-right rank_yellow_del" id="rank_2_del" rank="2" href="###"><i class="fa fa-trash-o"></i> 删除</a>
                    <a class="btn btn-xs btn-info pull-right rank_yellow_edit" id="rank_2_edit" rank="2" href="###"><i class="fa fa-edit"></i> 编辑</a>
                    <a class="btn btn-xs btn-success pull-right rank_yellow_add" id="rank_2_add" rank="2" href="###"><i class="fa fa-plus"></i> 添加</a>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="project_id" value="<?php echo ($project_id); ?>">
        <!-- /.row -->
    </div>
    <!-- /#wrapper -->


    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="/Public/Admin/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/bootstrap-switch.min.js"></script>

    <script type="text/javascript" src="/Public/Admin/js/layer/layer.js"></script>
    
    <script type="text/javascript">
    $(function() {
		bind_click();
    })
	
	function bind_click(){
		$("#yellow_menu .yellow_child").unbind();
		$("#yellow_menu .yellow_edit").unbind();
		$(".rank_yellow_add").unbind();
		$(".rank_yellow_edit").unbind();
		$(".rank_yellow_del").unbind();
		
		$(".rank_yellow_add").click(function(e) {
			var rank = $(this).attr("rank");
			var yellow_parent;
			if(rank == 0){
				yellow_parent = 0;
			}
			else if(rank == 1){
				yellow_parent = $("#rank_0 a.active").attr("yellow_id");
			}
			else if(rank == 2){
				yellow_parent = $("#rank_1 a.active").attr("yellow_id");
			}
            yellow_add(yellow_parent,rank);
        });
		$(".rank_yellow_edit").click(function(e) {
			var rank = $(this).attr("rank");
			var yellow_id = $(this).parent().siblings("a.active").attr("yellow_id");
			if(isNaN(yellow_id)){
				layer.msg("请先点击选择一个项目", {icon: 0});
			}
			else{
				yellow_edit(yellow_id,rank);
			}
        });
		$(".rank_yellow_del").click(function(e) {
			var rank = $(this).attr("rank");
			var yellow_id = $(this).parent().siblings("a.active").attr("yellow_id");
			if(isNaN(yellow_id)){
				layer.msg("请先点击选择一个项目", {icon: 0});
			}
			else{
				yellow_del(yellow_id,rank);
			}
        });
		$("#rank_0 .yellow_child").click(function(e) {
			var yellow_id = $(this).attr("yellow_id");
			$("#rank_0 a.list-group-item").removeClass("active");
			$("#rank_1 a.list-group-item").removeClass("active");
			$("#rank_2 a.list-group-item").removeClass("active");
			$(this).addClass("active");
            load_child(yellow_id,1);
        });
		$("#rank_0 .yellow_edit").click(function(e) {
			var yellow_id = $(this).attr("yellow_id");
			$("#rank_0 a.list-group-item").removeClass("active");
			$("#rank_1 a.list-group-item").remove();
			$("#rank_2 a.list-group-item").remove();
			$(this).addClass("active");
            yellow_edit(yellow_id,0);
        });
		$("#rank_1 .yellow_child").click(function(e) {
			var yellow_id = $(this).attr("yellow_id");
			$("#rank_1 a.list-group-item").removeClass("active");
			$("#rank_2 a.list-group-item").removeClass("active");
			$(this).addClass("active");
            load_child(yellow_id,2);
        });
		$("#rank_1 .yellow_edit").click(function(e) {
			var yellow_id = $(this).attr("yellow_id");
			$("#rank_1 a.list-group-item").removeClass("active");
			$("#rank_2 a.list-group-item").remove();
			$(this).addClass("active");
            yellow_edit(yellow_id,1);
        });
		$("#rank_2 .yellow_edit").click(function(e) {
			var yellow_id = $(this).attr("yellow_id");
			$("#rank_2 a.list-group-item").removeClass("active");
			$(this).addClass("active");
            yellow_edit(yellow_id,2);
        });
	}
	
	function load_child(yellow_id,rank){
		$("#rank_"+rank+" a.list-group-item").remove();
		$("#rank_"+rank).append("<i class='fa fa-spinner fa-3x fa-pulse text-success loading'></i>");
		var project_id = $("input[name='project_id']").val();
		$.post("/Admin/Yellow/yellow_list/",{
			"yellow_parent": yellow_id,
			"project_id": project_id,
		},function(data){
			$("#rank_"+rank+" i.loading").remove();
			if(data.err){
				layer.msg(data.msg, {icon: 0});
			}
			else{
				$(data.list).each(function(i,val) {
					var a_str = "";
					if(val.yellow_have_child>0 && rank<2){
						a_str = '<a href="###" class="list-group-item yellow_child" yellow_id="'+val.yellow_id+'">'+val.yellow_name+'<i class="fa fa-lg fa-arrow-right pull-right"></i></a>';
					}
					else{
						a_str = '<a href="###" class="list-group-item yellow_edit" yellow_id="'+val.yellow_id+'">'+val.yellow_name+'<i class="fa fa-lg fa-edit pull-right"></i></a>';
					}
					$("#rank_"+rank+" .list-group").append(a_str);
				}); 
				for(var i = 2;i>rank;i--){
					$("#rank_"+i+" a.list-group-item").remove();
				}
				bind_click();
			}
		},"json");
	}
	
	function yellow_edit(yellow_id,rank){
		if(isNaN(yellow_id)){
			layer.msg("请先点击选择一个项目", {icon: 0});
			return;
		}
		
		layer.load(1, {shade: [0.4,'#000']});
		$.get("/Admin/Yellow/yellow_edit/",{
			yellow_id : yellow_id,
		},
		function(data){
			layer.closeAll('loading');
			layer.open({
				type: 1,
				skin: 'layui-layer-rim', //加上边框
				area: '800px', //宽高
				content: data,
			});
		},"html");
		
	}
	function yellow_add(yellow_parent,rank){
		if(isNaN(yellow_parent)){
			layer.msg("请先点击选择一个上级项目", {icon: 0});
			return;
		}
		
		layer.load(1, {shade: [0.4,'#000']});
		var project_id = $("input[name='project_id']").val();
		$.get("/Admin/Yellow/yellow_add/",{
			yellow_parent : yellow_parent,
			project_id : project_id,
		},
		function(data){
			layer.closeAll('loading');
			layer.open({
				type: 1,
				skin: 'layui-layer-rim', //加上边框
				area: '800px', //宽高
				content: data,
			});
		},"html");
	}
	
	function yellow_del(yellow_id,rank){
		if(isNaN(yellow_id)){
			layer.msg("请先点击选择一个项目", {icon: 0});
			return;
		}
		
		layer.confirm('删除操作会同时删除该项目下的所有子项目，确认删除？',
		function(){
			layer.load(1, {shade: [0.4,'#000']});
			
			$.post("/Admin/Yellow/yellow_del/",{
				"yellow_id": yellow_id,
			},function(data){
				layer.closeAll('loading');
				if(data.err){
					layer.msg(data.msg, {icon: 0});
				}
				else{
					layer.closeAll('page');
					layer.msg(data.msg);
					if(rank > 0){
						var parent = $("#rank_"+(rank-1)+" a.active").attr("yellow_id");
						load_child(parent,rank);	
					}
					else{
						load_child(0,0);	
					}
				}
			},"json");
		});
	}
    </script>


</body>

</html>