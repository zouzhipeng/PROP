<?php
namespace Admin\Controller;

class Check{
    public function check(){
		//session(null);
		/* echo(session("?uin"));
		exit(); */
		if(session("?uin") == false){
			$token = session("token");
			//$token = 'e6b8AgMBUgUHUlJTVVBdBgoJB1UHVgACBlEACQRUVQRXAgoDBAZaBg';
			import("Common.Common.Mxmember");
			$Mxmember = new \Mxmember();
			$info = json_decode($Mxmember->memberinfo($token),true);
			if($info["status"] == 1){
				session("token",$token);
				session("uin",$info["data"]["uin"]);
				session("phone",$info["data"]["phone"]);
				$project_list = M("project_manager")->where("uin=%d",$info["data"]["uin"])->getField("project_id",true);
				if(empty($project_list)){
					session("project_list",array(""));
				}
				else{
					session("project_list",$project_list);
				}
			}
			elseif(session("?token")){
				//echo(session("token"));
				//var_dump($info);
				header("location: ".C('USER_API').'http://'.$_SERVER['HTTP_HOST'].U("Login/index")."?backurl=".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
				exit();
			}
			else{
				//echo(U("Login")."?backurl=".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
				header("location: ".U("Login/index")."?backurl=".'http://'.$_SERVER['HTTP_HOST'].'/'.MODULE_NAME.'/'.CONTROLLER_NAME);
				exit();
			}			
			
		}
		return true;
	}
	
    public function get_project_id(){
		$project_id = I("request.project_id",0,"int");		
		
		//检查项目权限
		$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
		if(!$result){
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
			exit();
		}
		else{
			return $project_id;
		}
	}	
}