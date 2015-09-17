<?php
namespace Prop\Controller;
use Think\Controller;
class IdleController extends Controller {
	
	public function _initialize(){
		require(APP_PATH.'Prop/Language/'.C('Lang').'/Idle.php');//载入语言类
		Check::check();
		$this->T = "idle";
   }	
	
    public function index(){		
		$is_my = I("get.is_my",0,"int");
		$this->assign('is_my',$is_my);
		$this->display();
	}
	
    public function add_idle(){
		if(IS_POST){
			import("Common.Common.Qiniu");
			$Qiniu = new \Qiniu();
			
			$idle_img = array();
			if(!empty($_FILES["idle_img_1"]['tmp_name']))$idle_img[] = $Qiniu->putFile($_FILES["idle_img_1"]);
			if(!empty($_FILES["idle_img_2"]['tmp_name']))$idle_img[] = $Qiniu->putFile($_FILES["idle_img_2"]);
			if(!empty($_FILES["idle_img_3"]['tmp_name']))$idle_img[] = $Qiniu->putFile($_FILES["idle_img_3"]);
			if(!empty($_FILES["idle_img_4"]['tmp_name']))$idle_img[] = $Qiniu->putFile($_FILES["idle_img_4"]);
			if(!empty($_FILES["idle_img_5"]['tmp_name']))$idle_img[] = $Qiniu->putFile($_FILES["idle_img_5"]);
			$idle_name = I("post.idle_name","");
			$idle_type = I("post.idle_type",0,"int");
			$idle_original_price = I("post.idle_original_price",0,"float");
			$idle_present_price = I("post.idle_present_price",0,"float");
			$idle_description = I("post.idle_description","");
			$project_id = Check::get_project_id();
			
			if(!empty($idle_name)){
				
				$data["idle_img"] = implode(',',$idle_img);
				$data["idle_name"] = $idle_name;
				$data["idle_original_price"] = $idle_original_price;
				$data["idle_present_price"] = $idle_present_price;
				$data["idle_description"] = $idle_description;
				$data["idle_type"] = $idle_type;
				$data["add_time"] = gtstamp();
				$data['project_id'] = $project_id;
				$data['uin'] = session("uin");
				
				$result = M($this->T)->data($data)->add();
				
				err_alert($this->LANG["add_ok"],U("Prop/Idle/index"));
			}
			
		}
		else{
			$this->display();
		}
	}
	
    public function add_buyidle(){		
		$this->display();
	}
	
    public function idle_list(){
		$last_id = I("get.last_id",0,"int");
		$pagesize = I("get.pagesize",20,"int");
		$project_id = Check::get_project_id();
		
		if($last_id>0){
			$condition['idle_id'] = array('lt',$last_id);
		}
		$condition['idle_state'] = 1;
		$condition['project_id'] = $project_id;
		
		$result = M($this->T)->where($condition)->limit($pagesize)->order('idle_id desc')->select();
		//echo(M($this->T)->_sql());
		// 更新时间值
		foreach($result as $k => $v){
			$result[$k]["add_time"] = ststamp($result[$k]["add_time"],'Y-m-d H:i');		
			$result[$k]["idle_img"] = explode(',',$result[$k]["idle_img"]);		
		}
		
		$this->assign('list',$result);
		$this->display();
	}

    public function my_idle(){
		$idle_type = I("get.idle_type",0,"int");
		$pagesize = I("get.pagesize",20,"int");
		$project_id = Check::get_project_id();
		$this->assign('idle_type',$idle_type);
		
		$condition['idle_type'] = $idle_type;
		$condition['uin'] = session('uin');
		$condition['project_id'] = $project_id;
		
		$result = M($this->T)->where($condition)->select();
		
		// 更新时间值
		foreach($result as $k => $v){
			$result[$k]["add_time"] = ststamp($result[$k]["add_time"],'Y-m-d H:i');		
			$result[$k]["idle_img"] = explode(',',$result[$k]["idle_img"]);		
		}
		
		$this->assign('list',$result);
		$this->display();
	}
	
	
    public function idle_info(){
		$idle_id = I("get.idle_id",0,"int");
		$project_id = Check::get_project_id();
		
		$condition['idle_id'] = $idle_id;
		$condition['project_id'] = $project_id;
		$condition['_complex'] = array("uin"=>session('uin'),"idle_state"=>array("GT",0),'_logic' =>'or');		
		
		$result = M($this->T)->where($condition)->find();
		
		if($result){
			$result["add_time"] = ststamp($result["add_time"],'Y-m-d H:i');
		}
		else{
			err_alert($this->LANG["err_noidle"]);
		}
		// 更新时间值
		$result["add_time"] = ststamp($result["add_time"],'Y-m-d H:i');	
		$result["idle_img_list"] = explode(',',$result["idle_img"]);	
		
		$this->assign('info',$result);
		$this->display();
	}		
}

