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
                    闲置信息
                    <?php if(is_array($project_list)): $i = 0; $__LIST__ = $project_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><a class="btn btn-sm <?php if($item["h_id"] == $project_id): ?>btn-success<?php else: ?>btn-default<?php endif; ?>" href="<?php echo U('Admin/Idle/index',array('project_id'=>$item['h_id']));?>" bill_id="<?php echo ($item["h_id"]); ?>"><i class="fa fa-building fa-lg"></i> <?php echo ($item["project"]); ?></a>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="<?php echo C('ENTRYDOMAIN');?>" target="_parent">首页</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-cubes"></i> 物业中心
                    </li>
                    <li class="active">
                        <i class="fa fa-retweet"></i> 闲置信息
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive" id="content_table">
                </div>
                <nav>
                    <ul class="pagination" id="page">
                    </ul>
                    <div class="total">共有<span class="count"></span>条记录</div>
                </nav>
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
    
    <link rel="stylesheet" href="/Public/kindeditor/themes/default/default.css" />
    <script charset="utf-8" src="/Public/kindeditor/kindeditor-min.js"></script>
    <script charset="utf-8" src="/Public/kindeditor/lang/zh_CN.js"></script>
    
    <script type="text/javascript">
	var chang_event = true;
	var page = 1;
	var editor;
    $(function() {
		data_bind(page);
		$("#idle_add").click(function(e) {
            idle_add();
        });
	
    })
	
	function data_bind(page){
		var project_id = $("input[name='project_id']").val();
		//加载等待
		layer.load(1, {
			shade: [0.4,'#000'] //0.1透明度的白色背景
		});
		var data = {};
		$("table .Dropdown").each(function(index, element) {
			if($(element).attr("value")!=""){
				data[$(element).attr("field")] = $(element).attr("value");
			}
        });
		data["project_id"] = project_id;
		data["page"] = page;
		$.post("/Admin/Idle/search/",data,function(data){
			$("#content_table").html(data.content);
			page_bind(data.page,data.count,data.pagesize);
			layer.closeAll('loading');
			$("table .Dropdown li").click(function(e) {
				$(this).parents(".Dropdown").attr("value",$(this).attr("value"));
				page = 1;
				data_bind(page);
			});			

			$(".idle_verify").click(function(e) {
				idle_verify($(this));
			});
			$(".idle_edit").click(function(e) {
				idle_edit($(this).attr("idle_id"));
			});
			$(".idle_del").click(function(e) {
				var idle_id = $(this).attr("idle_id");
				layer.confirm('确认要删除?', function(index){
					//do something
					idle_del(idle_id);
					layer.close(index);
				});  
			});
		},"json");
		
				

	}
	
	function page_bind(page,count,pagesize){
		$(".total .count").html(count);
		count = Math.ceil(count/pagesize);
		var page_str = "";
		if(page<=1){
			page_str += '<li class="disabled"><a href="###" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
		}
		else{
			page_str += '<li><a href="###" onClick="data_bind(1)" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
		}
		for(var i = page-4;i<=page+4;i++){
			if(i>=1&&i<=count){
				if(i==page){
					page_str += '<li class="active"><a href="###">'+i+' <span class="sr-only">(current)</span></a></li>';
				}
				else{
					page_str += '<li><a href="###" onClick="data_bind('+i+')">'+i+'</a></li>';
					
				}
			}
		}
		if(page>=count){
			page_str += '<li class="disabled"><a href="###" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
		}
		else{
			page_str += '<li><a href="###" onClick="data_bind('+count+')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
		}
		
		$('#page').html(page_str);
	}

	function idle_add(){
		layer.load(1, {shade: [0.4,'#000']});
		$.get("/Admin/Idle/idle_add/",{},
		function(data){
			layer.closeAll('loading');
			layer.open({
				type: 1,
				skin: 'layui-layer-rim', //加上边框
				area: '800px', //宽高
				zIndex: 2,
				content: data,
			});
		},"html");
	}
	
	function idle_verify(obj){
		var project_id = $("input[name='project_id']").val();
		var idle_id = $(obj).attr("idle_id");
		var idle_parent = $(obj).parent();
		$(idle_parent).html('<span class="text-success">已审核</span>');
		
		$.get("/Admin/Idle/idle_verify/",{
			"project_id": project_id,
			"idle_id":idle_id,
		},
		function(data){
			if(data.err>0){
				layer.msg(data.msg, {icon: 0});
				$(idle_parent).html('<button type="button" class="btn btn-sm btn-warning idle_verify" idle_id="'+idle_id+'">审核</button>');
				$(idle_parent).find(".idle_verify").click(function(e) {
					idle_verify($(this));
				});
			}
		},"json");
	}
	
	function idle_edit(idle_id){
		layer.load(1, {shade: [0.4,'#000']});
		$.get("/Admin/Idle/idle_edit/",{
			"idle_id": idle_id,
		},function(data){
			layer.closeAll('loading');
			if(data!=""){
				layer.open({
					type: 1,
					skin: 'layui-layer-rim', //加上边框
					area: '800px', //宽高
					content: data
				});
			}
		},"html");
	}
	
	function idle_del(idle_id){
		layer.load(1, {shade: [0.4,'#000']});
		$.post("/Admin/Idle/idle_del/",{
			"idle_id": idle_id,
		},function(data){
			layer.closeAll('loading');
			if(data.err){
				layer.msg(data.msg, {icon: 0});
			}
			else{
				layer.msg(data.msg);
				flash_page();
			}
		},"json");
	}
		
	function flash_page(){
		data_bind(page);
	}
	
    </script>


</body>

</html>