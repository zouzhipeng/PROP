<?php
namespace Admin\Controller;
use Think\Controller;
class CarpoolController extends Controller {
	
	public function _initialize(){
		require(APP_PATH.'Admin/Language/'.C('Lang').'/Carpool.php');//载入语言类
		Check::check();
		$this->T = "carpool";
    }	
	
    public function index(){
		$project_id = I("request.project_id",0,"int");

		$manager_T = M('project_manager');
		$condition['m.uin'] = session("uin");
		$result = $manager_T->alias('m')->join('INNER JOIN __PROJECT__ p ON m.project_id = p.h_id')->field("p.h_id,p.project")->where($condition)->select();
		if($result){
			$this->assign('project_list',$result);
			
			if($project_id <= 0)$project_id = $result[0]["h_id"];			
			$this->assign('project_id',$project_id);
		}
		$this->display();
	}
	
	public function search(){
		$condition = array();		
		$carpool_T = M($this->T);
		
		$project_id = I("request.project_id",0,"int");
		$carpool_type = I("request.carpool_type",0,"int");
		$carpool_state = I("request.carpool_state",-1,"int");
		$this->assign('carpool_type',$carpool_type);
		$this->assign('carpool_state',$carpool_state);
		
		
		//获取查询条件
		$page = I("request.page",1);
		$pagesize = I("request.pagesize",15);
		
		if($project_id > 0){
			$condition['project_id'] = $project_id;
		}
		else{
			$condition['project_id'] = array("in",implode(session("project_list"),","));
		}
		if($carpool_type > 0){
			$condition['carpool_type'] = $carpool_type;
		}
		if($carpool_state >= 0){
			$condition['carpool_state'] = $carpool_state;
		}
		
		$carpool_T->field("carpool_id,carpool_title,carpool_start,carpool_end,carpool_route,carpool_gotime,carpool_type,carpool_state,add_time,uin");
		$result = $carpool_T->where($condition)->order('carpool_id desc')->limit(($page-1)*$pagesize,$pagesize)->select();
		
		$count = M($this->T)->where($condition)->count();
		
		// 更新时间值和用户名
		// 批量读取uin信息
		import("Common.Common.Mxmember");
		$Mxmember = new \Mxmember();
		$uin_list = array();
		foreach($result as $k => $v){
			$result[$k]["add_time"] = ststamp($v["add_time"],'Y-m-d');
			$result[$k]["carpool_gotime"] = ststamp($v["carpool_gotime"],'Y-m-d H:i');
			$result[$k]["carpool_type_text"] = get_option_text("carpool_type",$v["carpool_type_text"]);
			$uin_list[] = intval($v["uin"]);
		}
		$uin_list = $Mxmember->member_info_data_arr($uin_list);
		$this->assign('uin_list',$uin_list);
		
		//var_dump($result);		
		$this->assign('list',$result);
		
		$content = $this->fetch('search_table');
		$r = array("content" =>$content,"count"=>$count,"page"=>$page,"pagesize"=>$pagesize);
		echo(json_encode($r));

	}
	
	public function carpool_verify(){
		$carpool_id = I("request.carpool_id",1);
		$project_id = I("request.project_id",0,"int");		
		
		//检查项目权限
		$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
		if(!$result){
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
			exit();
		}
		
		$carpool_T = M($this->T);
		$condition['project_id'] = $project_id;
		$condition['carpool_id'] = $carpool_id;
		$condition['carpool_state'] = 0;
		$result = $carpool_T->where($condition)->setField('carpool_state',1);
		if($result){
			echo(json_encode(array("err"=>0,"msg"=>$this->LANG['ok'])));
			exit();	
		}
		else{
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err'])));
			exit();	
		}
	}
	
	
	public function carpool_edit(){
		$carpool_id = I("request.carpool_id",0,"int");
		if(IS_POST){
			$carpool_id = I("request.carpool_id",0,"int");
			$carpool_title = I("request.carpool_title","");
			$carpool_route = I("request.carpool_route","");
			$carpool_gotime = I("request.carpool_gotime",0,"int");
			$carpool_type = I("request.carpool_type",0,"int");
			$carpool_state = I("request.carpool_state",0,"int");
			$carpool_remark = I("request.carpool_remark","");
			
			//数据检查
			$err = array("err"=>0,"msg"=>"");
			if($carpool_id <= 0){
				$err = array("err"=>1,"msg"=>$this->LANG['err_noidleid']);
			}
			if(empty($carpool_title)){
				$err = array("err"=>1,"msg"=>$this->LANG['err_carpooltitle']);
			}
			if($carpool_type < 0){
				$err = array("err"=>1,"msg"=>$this->LANG['err_nocarpooltype']);
			}
			if($carpool_state < 0){
				$err = array("err"=>1,"msg"=>$this->LANG['err_nocarpoolstate']);
			}
			if($err["err"] == 1){
				echo(json_encode($err));
				exit();
			}
			
			//检查项目权限
			$project_id = M($this->T)->where(array("carpool_id"=>$carpool_id))->getField('project_id');
			$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
			if(!$result){
				echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
				exit();
			}
		
			$carpool_T = M($this->T);
			$condition = array();
			$condition['carpool_id'] = $carpool_id;
			$condition['carpool_state'] = array('neq',2);
			$data = array();
			$data['carpool_title'] = $carpool_title;
			$data['carpool_route'] = $carpool_route;
			$data['carpool_gotime'] = gtstamp($carpool_gotime);
			$data['carpool_type'] = $carpool_type;
			$data['carpool_state'] = $carpool_state;
			$data['carpool_remark'] = $carpool_remark;
			$data['add_time'] = gtstamp();
			$result = $carpool_T->where($condition)->save($data);
			
			if($result){
				echo(json_encode(array("err"=>0,"msg"=>$this->LANG['ok'])));
				exit();	
			}
			else{
				echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err'])));
				exit();	
			}
		}
		else{
			$result = M($this->T)->where("carpool_id=%d",$carpool_id)->find();
			if($result){
				//检查project_manager权限
				$r = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$result["project_id"]))->count();
				if(!$r){
					die($this->LANG['err_noprojectid']);
				}
			}
			else{
				die($this->LANG['err_carpoolid']);
			}
			$result["carpool_gotime"] = ststamp($result["carpool_gotime"]);
			
			$this->assign('info',$result);
			$manager_T = M('project_manager');
			$this->display();
		}
	}
	
}