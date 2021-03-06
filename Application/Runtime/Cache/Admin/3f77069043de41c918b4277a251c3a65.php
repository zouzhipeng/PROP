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
                    账单信息
                    <?php if(is_array($project_list)): $i = 0; $__LIST__ = $project_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><a class="btn btn-sm <?php if($item["h_id"] == $project_id): ?>btn-success<?php else: ?>btn-default<?php endif; ?>" href="<?php echo U('Admin/Bill/index',array('project_id'=>$item['h_id']));?>" bill_id="<?php echo ($item["h_id"]); ?>"><i class="fa fa-building fa-lg"></i> <?php echo ($item["project"]); ?></a>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                    <a class="btn btn-sm btn-success" id="bill_add" href="###" bill_id="<?php echo ($item["bill_id"]); ?>"><i class="fa fa-plus fa-lg"></i> 添加</a>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="<?php echo C('ENTRYDOMAIN');?>" target="_parent">首页</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-cubes"></i> 物业中心
                    </li>
                    <li class="active">
                        <i class="fa fa-reorder"></i> 账单信息
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
    
    <!-- datetimepicker -->
    <script type="text/javascript" src="/Public/Admin/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="/Public/Admin/js/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    
    <script type="text/javascript">
	var chang_event = true;
	var page = 1;
	var editor;
    $(function() {
		data_bind(page);
		$("#bill_add").click(function(e) {
            bill_add();
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
		$.post("/Admin/Bill/search/",data,function(data){
			$("#content_table").html(data.content);
			page_bind(data.page,data.count,data.pagesize);
			layer.closeAll('loading');
			$("table .Dropdown li").click(function(e) {
				$(this).parents(".Dropdown").attr("value",$(this).attr("value"));
				page = 1;
				data_bind(page);
			});			

			$(".bill_edit").click(function(e) {
				bill_edit($(this).attr("bill_id"));
			});
			$(".bill_del").click(function(e) {
				var bill_id = $(this).attr("bill_id");
				layer.confirm('确认要删除?', function(index){
					//do something
					bill_del(bill_id);
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

	function bill_add(){
		layer.load(1, {shade: [0.4,'#000']});
		$.get("/Admin/Bill/bill_add/",{},
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
	
	
	function bill_edit(bill_id){
		layer.load(1, {shade: [0.4,'#000']});
		$.get("/Admin/Bill/bill_edit/",{
			"bill_id": bill_id,
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
	
	function bill_del(bill_id){
		layer.load(1, {shade: [0.4,'#000']});
		$.post("/Admin/Bill/bill_del/",{
			"bill_id": bill_id,
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