<?php
namespace Prop\Controller;
use Think\Controller;
class LoginController extends Controller {
	
	public function _initialize(){
		import("Common.Common.Mxmember");
    }	
	
    public function index(){
		//header("location: ".C('USER_API').'http://'.$_SERVER['HTTP_HOST'].U("Apilogin"));
	}
	
	
    public function Apilogin(){
		$backurl = I('get.backurl','');
		$token = I('get.token','');
		$this->assign('backurl',$backurl);
		if(I('get.token')){
			session("token",$token);
			header("location: ".$backurl);
		}
		
		$login_url=C('USER_API').'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."?backurl=".$backurl;
		$this->assign('login_url',$login_url);
		
		$this->display();
		
		/* if(I('get.token')){

			$token = I('get.token');
			$Mxmember = new \Mxmember();
			$info = json_decode($Mxmember->memberinfo($token),true);
			if($info["status"] == 1){
				session("token",$token);
				session("uin",$info["data"]["uin"]);
				session("phone",$info["data"]["phone"]);
				if(empty($backurl))
					$this->redirect("Index/index");
				else
					header("location: ".$backurl);
			}
			else{
				header("location: ".C('USER_API').'http://'.$_SERVER['HTTP_HOST'].U("Apilogin"));
			}
			
			//var_dump($info);
		}
		else{
			//echo U("login");
			//$this->redirect("login");
		} */
	}
	
    public function logout(){
		session(null);
		header("location: ".C('USER_CENTER').'/Public/loginout.html');
		exit();
		//$this->redirect("Index/index");
	}	
}