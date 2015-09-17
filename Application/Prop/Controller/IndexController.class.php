<?php
namespace Prop\Controller;
use Think\Controller;
class IndexController extends Controller {
	
	public function _initialize(){
		Check::check();
   }	
	
    public function index(){
		/* $Bdata = new \Bdata();
		 var_dump($Bdata->get_user(0,10000));
		 if(IS_POST){
			 import("Common.Common.Qiniu");
			 import("Common.Common.Bdata");
			 $Qiniu = new \Qiniu();

			 $url = $Qiniu->putFile($_FILES["upfile"]);			
			 echo $url.'<br>';
		 }
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');*/
		
		$project_id = Check::get_project_id();
		$project_info = M('project')->where('h_id=%d',$project_id)->find();
		$project_menu = unserialize($project_info["project_menu"]);
		
		//提醒
		$new_remind = Check::get_new_remind();
		foreach($project_menu as $k=>$v){
			if(!empty($v["menu_table"])){
				$now_time = M($v["menu_table"])->where(array("project_id"=>$project_id))->max("add_time");
				if(isset($new_remind[$v["menu_table"]]) && $new_remind[$v["menu_table"]] < $now_time){
					$project_menu[$k]["have_new"] = 1;
				}
			}
		}
		
		$project_info["project_menu"] = $project_menu;
		$project_info["project_config"] = unserialize($project_info["project_config"]);
		$this->assign('project_info',$project_info);
		$this->assign('project',Check::get_project());
		
		import("Common.Common.Lunar");
		$Lunar = new \Lunar();
		$Ldate_str = $Lunar->convertSolarToLunar(date("Y"), date("m"), date("d"));
		$this->assign('Ldate_str',$Ldate_str[3]."年".$Ldate_str[1]."".$Ldate_str[2]);
		$date_str = date(Y.'年'.m.'月'.d.'日', time());
		$this->assign('date_str',$date_str);
		
		
		
		$this->display();
	}
	
	public function d_register(){
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
			$house_list = Check::get_house(session("uin"),session("basic_id"),Check::get_project_id());
			$this->assign('house_list',$house_list);
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
			if(!session("?d_register_validatecode_".$phone)){
				
			}
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