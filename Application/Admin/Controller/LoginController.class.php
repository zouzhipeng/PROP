<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
	
    public function index(){
		$token = I('get.token','');		
		$backurl = I('get.backurl','');		
		$this->assign('backurl',$backurl);
		$entrydomain = C('ENTRYDOMAIN');		
		$this->assign('entrydomain',$entrydomain);
		if(I('get.token')){
			session("token",$token);
			//echo($backurl);
			header("location: ".$backurl);
		}
		else{
			$this->display();
		}
	}

}