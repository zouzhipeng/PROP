<?php
namespace Prop\Controller;
use Think\Controller;
class ServerController extends Controller {
	
	public function _initialize(){
		require(APP_PATH.'Prop/Language/'.C('Lang').'/Server.php');//载入语言类
		Check::check();
   }	
	
    public function index(){
		$is_my = I("get.is_my",0,"int");
		$this->assign('is_my',$is_my);
		$this->display();
	}
	
	public function serv_post(){
		import("Common.Common.Qiniu");
		$Qiniu = new \Qiniu();
		//import("Common.Common.Bdata");
		//$Bdata = new \Bdata();
		
		if(IS_POST){
			$server_class = I("post.server_class",0,"int");
			$field = array();
			if($server_class>0){
				$class_name = M("server_class")->where("server_class=%d",$server_class)->getField("server_class_name");
				$this->assign('class_name',$class_name);

				$server_field = M("server_field")->where("server_class=%d",$server_class)->select();
				$server_title = $class_name.":";
				foreach($server_field as $k => $v){
					if($v["field_type"] == "img"){
						$url = $Qiniu->putFile($_FILES["field_".$v["field_id"]]);
						
						$field[] = array(
							"field_id" => $v["field_id"],
							"value" => $url,
						);						
					}
					elseif($v["field_type"] == "option"){
						$field_value = I("post.field_".$v["field_id"],"");
						$server_title .= get_option_text($v["field_id"],$field_value)."-";
						$field[] = array(
							"field_id" => $v["field_id"],
							"value" => $field_value,
						);
					}
					elseif($v["field_type"] == "time"){
						$field_value = I("post.field_".$v["field_id"],"");
						$server_title .= $field_value."-";
						$field[] = array(
							"field_id" => $v["field_id"],
							"value" => gtstamp($field_value),
						);
					}
					elseif($v["field_type"] == "house"){
						$field_value = I("post.field_".$v["field_id"],"");
						$field[] = array(
							"field_id" => $v["field_id"],
							"value" => $field_value,
						);
					}

					else{
						$field_value = I("post.field_".$v["field_id"],"");
						$server_title .= $field_value."-";
						$field[] = array(
							"field_id" => $v["field_id"],
							"value" => $field_value,
						);
					}

				}
				
				if(empty($field)){
					err_alert($this->LANG["err_nofield"]);
				}
				
				$project_id = Check::get_project_id();
				$data = array(
					"server_class" => $server_class,
					"uin" => session("uin"),
					"add_time" => gtstamp(),
					"server_title" => $server_title,					
					"project_id" => $project_id,					
				);
				$return = M("server")->data($data)->add();
				
				if($return){
					foreach($field as $k => $v){
						M("server_value")->data(array("field_id"=>$v["field_id"],"server_id"=>$return,"value"=>$v["value"]))->add();
					}
				}
				else{
					err_alert($this->LANG["err_nofield"]);
				}
				err_alert($this->LANG["ok"],U("Prop/Server/index"));
			}
			
		}else{
			$server_class = I("get.server_class",0,"int");
			$this->assign('server_class',$server_class);
			
			$project_id = Check::get_project_id();
			
			if($server_class>0){
				$class_name = M("server_class")->where("server_class=%d",$server_class)->getField("server_class_name");
				$this->assign('class_name',$class_name);
				
				$return = M("server_field")->where("server_class=%d",$server_class)->order('field_order desc,field_id desc')->select();
				foreach($return as $k => $v){
					if($v["field_type"] == "option"){
						$option = get_option("","",$v["field_id"]);
						$return[$k]["field_option"] = $option[$v["field_id"]];
					}
					elseif($v["field_type"] == "house"){
						//$option = $Bdata->get_house(session("basic_id"),array("trading_project"=>$project_id));
						$option = Check::get_house(session("uin"),session("basic_id"),Check::get_project_id());
						$return[$k]["field_option"] = $option;
					}
				}
				$this->assign('field',$return);
			}
			$this->display();
		}
	}
	
	public function serv_list(){
		$project_id = Check::get_project_id();
		
		$condition['project_id'] = $project_id;
		$condition['uin'] = session("uin");
		$condition['server_state'] = array('gt',0);

		$server_list = M("server")->where($condition)->select();
		if($server_list){
			foreach($server_list as $k => $v){
				$server_list[$k]["add_time"] = ststamp($v["add_time"],'Y-m-d');
			}
			$this->assign('serv_list',$server_list);
			$content = $this->fetch('serv_list');		
		}
		else{
			$content = "";
		}
		$r = array("content" =>$content);
		echo(json_encode($r));
		
	}
	
}
