<?php
namespace Event\Controller;
use Think\Controller;
class IndexController extends Controller {
	
	public function _initialize(){
		import("Common.Common.Mxmember");
    }	
	
    public function index(){
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
		
		echo session("token")."<br>";
		echo session("uin")."<br>";
		echo session("phone")."<br>";
		Event_C::add(array());
		
		$this->display();
	}
	
    public function login(){
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
		//echo(C('USER_API').'http://'.$_SERVER['HTTP_HOST'].U("Apilogin"));
		header("location: ".C('USER_API').'http://'.$_SERVER['HTTP_HOST'].U("Apilogin"));
		//$this->redirect("http://www.163.com/");
		//$this->success("输出的提示信息","http://www.163.com/");
		//$this->redirect(C('USER_API').'http://'.$_SERVER['HTTP_HOST'].U("Index"));
	}
	
	
    public function Apilogin(){
		$backurl = I('get.backurl','');		
		if(I('get.token')){

			$token = I('get.token');
			$Mxmember = new \Mxmember();
			$info = json_decode($Mxmember->memberinfo($token),true);
			if($info["status"] == 1){
				session("token",$token);
				session("uin",$info["data"]["uin"]);
				session("phone",$info["data"]["phone"]);
				if(empty($backurl))
					$this->redirect("index");
				else
					header("location: ".$backurl);
			}
			
			//var_dump($info);
		}
		else{
			//echo U("login");
			//$this->redirect("login");
			$this->display();
		}
	}	
}