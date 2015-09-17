<?php
namespace Prop\Controller;
use Think\Controller;
class DregisterController extends Controller {
	
	public function _initialize(){
		Check::check();
   }	
	

	public function index(){
		if(IS_POST){
			$user_house_id = I("post.user_house_id",0,"int");
			$project_id = I("post.project_id",0,"int");
			$project_name = I("post.project_name","");
			$building = I("post.building","");
			$room_number = I("post.room_number","");
			$phone = I("post.phone","");
			$password = I("post.password","");
			$validatecode = I("post.validatecode","");
			
			if(empty($phone) || empty($password)){
				$err = array("err"=>1,"msg"=>"提交数据错误");
				echo(json_encode($err));
				exit();
			}
			if(session("phone") == $phone){
				$err = array("err"=>1,"msg"=>"不要添加自己");
				echo(json_encode($err));
				exit();
			}
			if(session("d_register_validatecode_".$phone) != $validatecode){
				$err = array("err"=>1,"msg"=>"验证码错误");
				echo(json_encode($err));
				exit();
			}
			
			//先注册
			import("Common.Common.Mxmember");
			$Mxmember = new \Mxmember();
			$info = json_decode($Mxmember->phone_is($phone),true);
			if($info["status"] == 1){
				$uin = $info["info"];
			}
			else{
				$info = $Mxmember->register($phone,$password,$validatecode);
				$info = json_decode($Mxmember->phone_is($phone),true);
				if($info["status"] == 1){
					$uin = $info["info"];
				}
				else{
					$err = array("err"=>1,"msg"=>"注册失败");
					echo(json_encode($err));
					exit();
				}
			}
			
			//检查大数据,若大数据已有数据则不添加
			import("Common.Common.Bdata");
			$Bdata = new \Bdata();
			$user_info = $Bdata->get_user($uin);
			$Basic_id = $user_info["user_result"][0]["Basic_id"]["value"];
			$condition = array();
			//$condition["Basic_id"] = $Basic_id;
			$condition["trading_project"] = $project_id;
			$condition["trading_building"] = $building;
			$condition["trading_room_number"] = $room_number;
			$result = $Bdata->get_house($Basic_id,$condition);
			if($result["totalCount"]>0){
				$err = array("err"=>0,"msg"=>"用户已绑定！！");
				echo(json_encode($err));
				exit();
			}
			
			$data = array();
			$data["uin"] = $uin;
			$data["reside_type"] = 1;
			$data["user_house_id"] = $user_house_id;
			$data["project_id"] = $project_id;
			$data["project_name"] = $project_name;
			$data["building"] = $building;
			$data["room_number"] = $room_number;
			
			//判断是否已绑定
			$u_count = M("reside_user")->where($data)->count();
			if($u_count>0){
				$err = array("err"=>0,"msg"=>"用户已绑定！");
				echo(json_encode($err));
				exit();
			}
			
			$result = M("reside_user")->data($data)->add();
			if($result){
				$err = array("err"=>0,"msg"=>"注册成功");
			}
			else{
				$err = array("err"=>1,"msg"=>"注册失败");
			}		
			echo(json_encode($err));
			exit();				
		}
		else{
			//$house_list = Check::get_house(session("uin"),session("basic_id"),Check::get_project_id());
			//$this->assign('house_list',$house_list);
			
			$result = M("project")->field("h_id,project")->select();
			$this->assign('project_list',$result);
			$this->display();
		}
	}
	
	public function send_validatecode(){
		
		if(IS_POST){
			$phone = I("post.phone","");
			if(empty($phone)){
				exit();
			}
			import("Common.Common.Mxmember");
			$Mxmember = new \Mxmember();
			
			session("d_register_validatecode_".$phone,self::random(6));
			$Mxmember->register_phone_sms($phone,session("d_register_validatecode_".$phone));
		}
	}
	
	function random($len) {
		$srcstr = "1234567890";
		mt_srand();
		$strs = "";
		for ($i = 0; $i < $len; $i++) {
			$strs .= $srcstr[mt_rand(0, strlen($srcstr)-1)];
		}
		return $strs;
	}
	
}