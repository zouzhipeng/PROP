<?php
namespace Prop\Controller;

class Check{
    public function check(){
		$uin = I('get.uin',0,"int");
		if(session("?uin") && $uin>0 && session("uin") != $uin){
			session(null);
			session("uin",$uin);
		}
		//session(null);
		/* echo(session("?uin"));
		exit(); */
		if(session("?uin") == false || session("?token") == false || session("?basic_id") == false){
			$token = session("token");
			//$token = 'e6b8AgMBUgUHUlJTVVBdBgoJB1UHVgACBlEACQRUVQRXAgoDBAZaBg';
			import("Common.Common.Mxmember");
			$Mxmember = new \Mxmember();
			$info = $Mxmember->memberinfo($token);
			$info = json_decode($info,true);
			if($info["status"] == 1){
				//session("token",$token);
				session("uin",$info["data"]["uin"]);
				session("basic_id",$info["data"]["basic_id"]);
				session("phone",$info["data"]["phone"]);
				session("face",$info["data"]["weixin_info"]["headimgurl"]);
				$project_list = M("project_manager")->where("uin=%d",$info["data"]["uin"])->getField("project_id",true);
				if(empty($project_list)){
					session("project_list",array(""));
				}
				else{
					session("project_list",$project_list);
				}
				
				//添加用户记录
				$r = M('user')->where('uin='.$info["data"]["uin"])->count();
				if($r){
					M('user')->where('uin='.$info["data"]["uin"])->save(array('session_id'=>session_id())); 
				}
				else{
					M('user')->add(array('uin'=>$info["data"]["uin"],'session_id'=>session_id())); 
				}
				
			}
			//如果session("?token")已存在则可能是别处退出则重新登录更新session("?token")
			elseif(session("?token")){
				//echo(session("token"));
				session(null);
				header("location: ".C('USER_API').'http://'.$_SERVER['HTTP_HOST'].U("Login/Apilogin")."?backurl=".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
				exit();
			}
			//如果session("?token")不存在则去取token
			else{
				header("location: http://".$_SERVER['HTTP_HOST'].U("Login/Apilogin")."?backurl=".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
				exit();
			}
			
		}
		//echo(session("uin"));
		return true;
	}
	
	public function get_project_id(){
		$project_id = I('get.project_id',0,"int");
		//$project_id = 0;
		$old_project_id = session("project_id");
		if($project_id > 0){
			if($project_id == $old_project_id){
				return $project_id;
			}
			
			//import("Common.Common.Bdata");
			//$Bdata = new \Bdata();
			
			//$User_house = $Bdata->get_house(session("basic_id"));
			$User_house = self::get_house(session("uin"),session("basic_id"),$project_id);
			foreach($User_house as $k => $v){
				if($v["project_id"] == $project_id){

					session("project_id",$project_id);
					return $project_id;
					break;
				}
			}
		}
		else{
			//session("project_id", null);
			if(session("project_id")){
				return session("project_id");
			}
			
			//import("Common.Common.Bdata");
			//$Bdata = new \Bdata();
			//$User_house = $Bdata->get_house(session("basic_id"));
			$User_house = self::get_house(session("uin"),session("basic_id"),$project_id);
			if($User_house){
				session("project_id",$User_house[0]["project_id"]);
				return $User_house[0]["project_id"];
			}
		}
		
		//跳转认证.base64_encode("http://prop.guanyu.cn/")
		header("location: ".sprintf(C("HOUSE_API.LEIXINGURL"),base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])));
		exit();				
		return false;
		
	}
	
	public function get_project(){
		//if(session("project")){
		//	return session("project");
		//}
		//else{
			if(session("project_id"))
				$project_id = session("project_id");
			else
				$project_id = self::get_project_id();
			
			if($project_id){
				$project = M("project")->where("h_id=%s",$project_id)->getField("project");
				session("project",$project);
				return $project;
			}
			else{
				return false;
			}
		//}
	}
	
	public function get_now_house($house_id = 0, $basic_id = -1){
		if($basic_id == -1) $basic_id = session("basic_id");
		if(($house_id == 0 && session("?now_house")) || ($house_id > 0 && $house_id == session("now_house_id"))){
			return session("now_house");
		}
		else{
			$project_id = self::get_project_id();
			
			//import("Common.Common.Bdata");
			//$Bdata = new \Bdata();
			$data = array();			
			if($house_id > 0){
				$data["user_house_id"] = $house_id;
			}
			//$User_house = $Bdata->get_house($basic_id,$data);
			$User_house = self::get_house(session("uin"),$basic_id,$project_id,$data);

			if($User_house){
				//$User_house[0]["project"] = array("name"=>"","value"=>M("project")->where("h_id=%s",$project_id)->getField("project"));
				$User_house[0]["project"] = $User_house[0]["project_name"];
				session(array('name'=>'now_house','expire'=>3600));
				session('now_house',$User_house[0]);
				session(array('name'=>'now_house_id','expire'=>3600));
				session('now_house_id',$User_house[0]["user_house_id"]);
				return $User_house[0];
			}
		}
		
		return false;
		
	}
	
	public function get_new_remind(){
		$new_remind = M("user")->where(array("uin"=>session("uin")))->getField("new_remind");
		return unserialize($new_remind);		
	}
	public function set_new_remind($table,$time){
		$new_remind = M("user")->where(array("uin"=>session("uin")))->find();
		if($new_remind){
			$new_remind = unserialize($new_remind["new_remind"]);
			$new_remind[$table] = $time;
			$new_remind = serialize($new_remind);
			M("user")->where(array("uin"=>session("uin")))->setField("new_remind",$new_remind);
		}
		else{
			$new_remind[$table] = $time;
			$new_remind = serialize($new_remind);
			$data['uin'] = session("uin");
			$data['new_remind'] = $new_remind;
			M("user")->add($data);
		}
		return true;
	}
	
	public function get_house($uin,$basic_id,$project_id,$data = array()){
		import("Common.Common.Bdata");
		$Bdata = new \Bdata();
		if($project_id > 0){
			$data["trading_project"] = $project_id;
		}
		$r = $Bdata->get_house(session("basic_id"),$data);
		$result = array();
		if($r["error_code"] == 0){
			foreach($r["user_result"] as $k => $v){
				$house = array();
				$house["user_house_id"] = $v['user_house_id']['value'];
				$house["reside_type"] = 1;
				$house["project_id"] = $v["trading_project"]['value'];
				$house["project_name"] = $v["trading_project_name"]['value'];
				$house["building"] = $v["trading_building"]['value'];
				$house["room_number"] = $v["trading_room_number"]['value'];
				$result[] = $house;
			}
		}
		/* else{
			$r = M("reside_user")->where(array("uin"=>$uin,"project_id"=>$project_id))->select();
			if($r){
				$result = $r;
			}
			else{
				return false;
			}
		} */
		
		$r = M("reside_user")->where(array("uin"=>$uin,"project_id"=>$project_id))->select();
		if($r){
			$result = array_merge($result, $r);
		}
		
		if(empty($result)){
			return false;
		}

		
		return $result;
	}
}