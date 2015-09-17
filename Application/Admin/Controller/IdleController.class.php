<?php
namespace Admin\Controller;
use Think\Controller;
class IdleController extends Controller {
	
	public function _initialize(){
		require(APP_PATH.'Admin/Language/'.C('Lang').'/Idle.php');//载入语言类
		Check::check();
		$this->T = "idle";
    }	
	
    public function index(){
		//echo(session("uin"))."-----".session("project_list");
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
		$idle_T = M($this->T);
		
		$project_id = I("request.project_id",0,"int");		
		$idle_type = I("request.idle_type",-1,"int");
		$idle_state = I("request.idle_state",-1,"int");
		$this->assign('idle_type',$idle_type);
		$this->assign('idle_state',$idle_state);
		
		//获取查询条件
		$page = I("request.page",1);
		$pagesize = I("request.pagesize",15);
		
		if($project_id > 0){
			$condition['project_id'] = $project_id;
		}
		else{
			$condition['project_id'] = array("in",implode(session("project_list"),","));
		}
		if($idle_type >= 0){
			$condition['idle_type'] = $idle_type;
		}
		if($idle_state >= 0){
			$condition['idle_state'] = $idle_state;
		}
		
		$idle_T->field("idle_id,idle_type,idle_name,idle_original_price,idle_present_price,idle_state,add_time,uin");
		$result = $idle_T->where($condition)->order('idle_id desc')->limit(($page-1)*$pagesize,$pagesize)->select();
		
		$count = M($this->T)->where($condition)->count();
		
		// 更新时间值和用户名
		// 批量读取uin信息
		import("Common.Common.Mxmember");
		$Mxmember = new \Mxmember();
		$uin_list = array();
		foreach($result as $k => $v){
			$result[$k]["add_time"] = ststamp($result[$k]["add_time"],'Y-m-d');
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
	
	
    public function idle_verify(){
		$idle_id = I("request.idle_id",1);
		$project_id = I("request.project_id",0,"int");		
		
		//检查项目权限
		$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
		if(!$result){
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
			exit();
		}
		
		$idle_T = M($this->T);
		$condition['project_id'] = $project_id;
		$condition['idle_id'] = $idle_id;
		$condition['idle_state'] = 0;
		$result = $idle_T->where($condition)->setField('idle_state',1);
		if($result){
			//发短信通知发布人
			$idle = $idle_T->where($condition)->find();
			import("Common.Common.Mxmember");
			$Mxmember = new \Mxmember();
			$user_info = $Mxmember->memberinfo_uin($idle["uin"]);
			$Mxmember->send_sms($user_info["data"]["phone"],sprintf($this->LANG["sms_content"],ststamp($idle["add_time"]),$idle["idle_name"]),$this->LANG["sms_sign"]);
			
			echo(json_encode(array("err"=>0,"msg"=>$this->LANG['ok'])));
			exit();	
		}
		else{
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err'])));
			exit();	
		}
	}
	
	public function idle_edit(){
		$idle_id = I("request.idle_id",0,"int");
		if(IS_POST){
			$idle_id = I("request.idle_id",0,"int");
			$idle_name = I("request.idle_name","");
			$idle_type = I("request.idle_type",0,"int");
			$idle_original_price = I("request.idle_original_price",0,"float");
			$idle_present_price = I("request.idle_present_price",0,"float");
			$idle_state = I("request.idle_state",0,"int");
			$idle_description = I("request.idle_description","");
			
			//数据检查
			$err = array("err"=>0,"msg"=>"");
			if($idle_id <= 0){
				$err = array("err"=>1,"msg"=>$this->LANG['err_noidleid']);
			}
			if(empty($idle_name)){
				$err = array("err"=>1,"msg"=>$this->LANG['err_noidlename']);
			}
			if($idle_type < 0){
				$err = array("err"=>1,"msg"=>$this->LANG['err_noidletype']);
			}
			if($idle_original_price < 0){
				$err = array("err"=>1,"msg"=>$this->LANG['err_noprice']);
			}
			if($idle_original_price < 0){
				$err = array("err"=>1,"msg"=>$this->LANG['err_noprice']);
			}
			if($idle_state < 0){
				$err = array("err"=>1,"msg"=>$this->LANG['err_noidlestate']);
			}
			if($err["err"] == 1){
				echo(json_encode($err));
				exit();
			}
			
			//检查项目权限
			$project_id = M($this->T)->where(array("idle_id"=>$idle_id))->getField('project_id');
			$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
			if(!$result){
				echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
				exit();
			}
		
			$idle_T = M($this->T);
			$condition = array();
			$condition['idle_id'] = $idle_id;
			$condition['idle_state'] = array('neq',2);
			$data = array();
			$data['idle_name'] = $idle_name;
			$data['idle_type'] = $idle_type;
			$data['idle_original_price'] = $idle_original_price;
			$data['idle_present_price'] = $idle_present_price;
			$data['idle_state'] = $idle_state;
			$data['idle_description'] = $idle_description;
			$data['add_time'] = gtstamp();
			$result = $idle_T->where($condition)->save($data);
			
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
			$result = M($this->T)->where("idle_id=%d",$idle_id)->find();
			if($result){
				//检查project_manager权限
				$r = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$result["project_id"]))->count();
				if(!$r){
					die($this->LANG['err_noprojectid']);
				}
			}
			else{
				die($this->LANG['err_idleid']);
			}
			$result["idle_img_list"] = explode(',',$result["idle_img"]);	
			
			$this->assign('info',$result);
			$manager_T = M('project_manager');
			$this->display();
		}
	}
	
	public function idle_del(){
		$idle_id = I("request.idle_id",0,"int");
		
		$project_id = M($this->T)->where(array("idle_id"=>$idle_id))->getField('project_id');	
		
		//检查项目权限
		$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
		if(!$result){
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
			exit();
		}
		
		$result = M($this->T)->delete($idle_id);
		
		echo(json_encode(array("err"=>0,"msg"=>$this->LANG['ok'])));
		exit();	
		
	}
}
