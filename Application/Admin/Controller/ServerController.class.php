<?php
namespace Admin\Controller;
use Think\Controller;
class ServerController extends Controller {
	
	public function _initialize(){
		require(APP_PATH.'Admin/Language/'.C('Lang').'/Server.php');//载入语言类
		Check::check();
		$this->T = "server";
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
		$serv_T = M($this->T);
		
		$project_id = I("request.project_id",0,"int");
		$server_state = I("request.server_state",-1,"int");
		$this->assign('server_state',$server_state);
		$server_class = I("request.server_class",-1,"int");
		$this->assign('server_class',$server_class);
		
		
		
		//获取查询条件
		$page = I("request.page",1);
		$pagesize = I("request.pagesize",15);
		
		if($project_id > 0){
			$condition['s.project_id'] = $project_id;
		}
		else{
			$condition['s.project_id'] = array("in",implode(session("project_list"),","));
		}
		if($server_state >= 0){
			$condition['s.server_state'] = $server_state;
		}		
		if($server_class >= 0){
			$condition['s.server_class'] = $server_class;
		}		
		
		$serv_T->alias('s')->join('LEFT JOIN __SERVER_CLASS__ c ON s.server_class = c.server_class');
		$serv_T->field("s.*,c.server_class_name");
		$result = $serv_T->where($condition)->order('server_id desc')->limit(($page-1)*$pagesize,$pagesize)->select();
		
		$count = M($this->T)->alias('s')->where($condition)->count();
		
		// 更新时间值
		foreach($result as $k => $v){
			$result[$k]["add_time"] = ststamp($result[$k]["add_time"],'Y-m-d');		
		}
		//var_dump($result);
		$this->assign('list',$result);
		
		//批量读取uin信息
		import("Common.Common.Mxmember");
		$Mxmember = new \Mxmember();

		$uin_list = array();
		foreach($result as $k => $v){
			$uin_list[] = intval($v["uin"]);
			//$uin_list[$v["uin"]] = $Mxmember->memberinfo_uin($v["uin"]);
		}
		$uin_list = $Mxmember->member_info_data_arr($uin_list);
		$this->assign('uin_list',$uin_list);
		
		$content = $this->fetch('search_table');
		$r = array("content" =>$content,"count"=>$count,"page"=>$page,"pagesize"=>$pagesize);
		echo(json_encode($r));

	}
	
	public function serv_view(){
		import("Common.Common.Bdata");
		$Bdata = new \Bdata();
		
		$server_id = I("request.server_id",0,"int");
		$server = M($this->T)->where("server_id=%d",$server_id)->find();
		
		if($server){
			//检查project_manager权限
			$r = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$server["project_id"]))->count();
			if(!$r){
				die($this->LANG['err_noprojectid']);
			}
		}
		else{
			die($this->LANG['err_serverid']);
		}
		$this->assign('server_id',$server_id);
		$this->assign('info',$server);

		
		$condition['f.server_class'] = $server['server_class'];
		$condition['v.server_id'] = $server_id;
		
		$serv_T = M("server_field");
		$serv_T->alias('f')->join('LEFT JOIN __SERVER_VALUE__ v ON f.field_id = v.field_id');
		$serv_T->field("f.*,v.value")->order('f.field_order desc,f.field_id desc');
		$return = $serv_T->where($condition)->select();
		foreach($return as $k => $v){
			if($v["field_type"] == "option"){
				//$option = get_option("","",$v["field_id"]);
				//$return[$k]["field_option"] = $option[$v["field_id"]];
				$return[$k]['value'] = get_option_text($v["field_id"],$v["value"]);
			}
			elseif($v["field_type"] == "house"){
				//$option = $Bdata->get_house(session("basic_id"),array("trading_project"=>$project_id));
				//$return[$k]["field_option"] = $option["user_result"];
			}
			elseif($v["field_type"] == "time"){
				$return[$k]['value'] = ststamp($v['value'],'Y-m-d');
			}
		}
		//本记录设置为已读
		//M($this->T)->where("server_id=%d",$server_id)->setField('server_state',1);
		
		$this->assign('field',$return);

		$this->display();
	}

	public function serv_edit(){
		$server_id = I("request.server_id",0,"int");
		$server_state = I("request.server_state",-1,"int");

		//检查项目权限
		$project_id = M($this->T)->where(array("server_id"=>$server_id))->getField('project_id');
		$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
		if(!$result){
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
			exit();
		}
		
		if($server_state<0){
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err'])));
			exit();	
		}
		
		$server_T = M($this->T);
		$condition = array();
		$condition['server_id'] = $server_id;
		//$condition['idle_state'] = array('neq',2);
		$data = array();
		$data['server_state'] = $server_state;
		$result = $server_T->where($condition)->save($data);
		
		if($result){
			echo(json_encode(array("err"=>0,"msg"=>$this->LANG['ok'])));
			exit();	
		}
		else{
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err'])));
			exit();	
		}

		
	}	
	
	public function has_new(){
		$last_id = I("request.last_id",0,"int");
		$project_id = I("request.project_id",0,"int");
		
		$r = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
		if(!$r){
			die("0");
		}
		
		$condition = array();
		$condition['project_id'] = $project_id;		
		$condition['server_id'] = array('gt',$last_id);
		$result = M($this->T)->where($condition)->count();
		
		if($result>0){
			die("1");
		}
		else{
			die("0");
		}
		
	}
}
	
	
	