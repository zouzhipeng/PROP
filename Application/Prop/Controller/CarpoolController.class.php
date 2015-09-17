<?php
namespace Prop\Controller;
use Think\Controller;
class CarpoolController extends Controller {
	
	public function _initialize(){
		require(APP_PATH.'Prop/Language/'.C('Lang').'/Carpool.php');//载入语言类
		Check::check();
		$this->T = "carpool";
    }

	public function index(){
		$is_my = I("get.is_my",0,"int");
		$this->assign('is_my',$is_my);
		$filter_time = array(
			"当天" => date("Y-m-d"),
			"三天内" => date("Y-m-d",strtotime("-3 day")),
			"一周内" => date("Y-m-d",strtotime("-1 week")),
			"一个月内" => date("Y-m-d",strtotime("-1 month")),
		);
		
		$this->assign('filter_time',$filter_time);
		
		$this->display();
	}
	
	public function carpool_list(){
		$filter_type = I("get.filter_type","");
		$filter_time = I("get.filter_time","");
		
		$last_id = I("get.last_id",0,"int");
		$pagesize = I("get.pagesize",20,"int");
		$project_id = Check::get_project_id();
		
		if($last_id>0){
			$condition['carpool_id'] = array('lt',$last_id);
		}
		if(!empty($filter_type)){
			$condition['carpool_type'] = $filter_type;
		}
		if(!empty($filter_time)){
			$condition['carpool_gotime'] = array('gt',gtstamp($filter_time));
		}
		$condition['carpool_state'] = 1;
		$condition['project_id'] = $project_id;
		
		$result = M($this->T)->where($condition)->limit($pagesize)->order('carpool_id desc')->select();
		if($last_id>0 && empty($result)) return;
		
		//echo(M($this->T)->_sql());
		// 更新时间值
		foreach($result as $k => $v){
			$result[$k]["add_time"] = ststamp($result[$k]["add_time"],'Y-m-d H:i');		
			$result[$k]["carpool_gotime"] = ststamp($result[$k]["carpool_gotime"],'Y-m-d H:i');		
		}

		$this->assign('list',$result);
		$this->display();
	}	
	
	public function add_carpool(){
		if(IS_POST){
			import("Common.Common.Qiniu");
			$Qiniu = new \Qiniu();
			
			$carpool_img = $Qiniu->putFile($_FILES["carpool_img"]);
			$carpool_title = I("post.carpool_title","");
			$carpool_start = I("post.carpool_start","");
			$carpool_end = I("post.carpool_end","");
			$carpool_route = I("post.carpool_route","");
			$carpool_gotime = I("post.carpool_gotime","");
			$carpool_type = I("post.carpool_type",0,"int");
			$carpool_remark = I("post.carpool_remark","");
			$project_id = Check::get_project_id();
			
			if(!empty($carpool_title)){
				
				$data["carpool_img"] = $carpool_img;
				$data["carpool_title"] = $carpool_title;
				$data["carpool_start"] = $carpool_start;
				$data["carpool_end"] = $carpool_end;
				$data["carpool_route"] = $carpool_route;
				$data["carpool_gotime"] = gtstamp($carpool_gotime);
				$data["carpool_type"] = $carpool_type;
				$data["carpool_remark"] = $carpool_remark;
				$data["add_time"] = gtstamp();
				$data['project_id'] = $project_id;
				$data['uin'] = session("uin");
				
				$result = M($this->T)->data($data)->add();
				
				err_alert($this->LANG["add_ok"],U("Prop/Carpool/index"));
			}
			
		}
		else{
			$this->display();
		}
	}
	
	public function carpool_info(){
		$carpool_id = I("get.carpool_id",0,"int");
		$project_id = Check::get_project_id();
		
		$condition['carpool_id'] = $carpool_id;
		$condition['project_id'] = $project_id;
		
		$result = M($this->T)->where($condition)->find();
		
		if($result){
			$result["add_time"] = ststamp($result["add_time"],'Y-m-d H:i');
			$result["carpool_gotime"] = ststamp($result["carpool_gotime"],'Y-m-d H:i');
			$result["carpool_type_text"] = get_option_text("carpool_type",$result["carpool_type_text"]);
		}
		else{
			err_alert($this->LANG["err_nocarpool"].M($this->T)->_sql());
		}
		
		$this->assign('info',$result);
		$this->display();
	}

	public function my_carpool(){
		
		$last_id = I("get.last_id",0,"int");
		$pagesize = I("get.pagesize",20,"int");
		$project_id = Check::get_project_id();
		
		if($last_id>0){
			$condition['carpool_id'] = array('lt',$last_id);
		}
		$condition['project_id'] = $project_id;
		$condition['uin'] = session('uin');
		
		$result = M($this->T)->where($condition)->limit($pagesize)->order('carpool_id desc')->select();
		if($last_id>0 && empty($result)) return;
		
		//echo(M($this->T)->_sql());
		// 更新时间值
		foreach($result as $k => $v){
			$result[$k]["add_time"] = ststamp($result[$k]["add_time"],'Y-m-d H:i');		
			$result[$k]["carpool_gotime"] = ststamp($result[$k]["carpool_gotime"],'Y-m-d H:i');		
		}

		$this->assign('list',$result);
		$this->display();
	}

}