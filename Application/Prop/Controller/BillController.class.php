<?php
namespace Prop\Controller;
use Think\Controller;
class BillController extends Controller {
	
	public function _initialize(){
		require(APP_PATH.'Prop/Language/'.C('Lang').'/Bill.php');//载入语言类
		Check::check();
		$this->T = "bill";
    }	
	
    public function index(){
		$token = session("token");
		import("Common.Common.Mxmember");
		$Mxmember = new \Mxmember();
		$info = $Mxmember->memberinfo($token);
		$info = json_decode($info,true);
		if($info["status"] != 1){
			session(null);
			header("location: http://".$_SERVER['HTTP_HOST'].U("Login/Apilogin")."?backurl=".U("index"));
			exit();
		}	
		
		//更新提醒时间
		$project_id = Check::get_project_id();
		$now_time = M($this->T)->where(array("project_id"=>$project_id))->max("add_time");
		Check::set_new_remind($this->T,$now_time);

		$house_id = I('get.house_id',0,"int");
		$house = Check::get_now_house($house_id);
		/* if(!$house){
			var_dump(session("now_house"));
		} */
		$this->assign('house',$house);
		
		$bill_T = M($this->T);
		$condition['project_id'] = $house["project_id"];
		$condition['building'] = $house["building"];
		$condition['room_number'] = $house["room_number"];
		$condition['status'] = 0; //未付款账单
		
		$result = $bill_T->field("bill_id,bill_title,bill_price,bill_time,status")->where($condition)->order('add_time desc')->select();
		foreach($result as $k => $v){
			$result[$k]["bill_time"] = ststamp($result[$k]["bill_time"],"Y-m-d");
		}
		
		$this->assign('project',Check::get_project());
		$this->assign('bill_list',$result);
		$this->display();
	}
	
		
    public function bill_list(){
		
		$house_id = I('get.house_id',0,"int");
		$house = Check::get_now_house($house_id);
		
		$start_time = I('post.start_time',"");
		$end_time = I('post.end_time',"");
		if(empty($start_time)){
			$start_time = date('Y-m-01',strtotime(date('Y',time()).'-'.(date('m',time())-1).'-01'));
		}
		if(empty($end_time)){
			$end_time = date('Y-m-d',strtotime("$start_time +2 month -1 day"));
		}
		$start_time = gtstamp($start_time);
		$end_time = gtstamp($end_time);

		$bill_T = M($this->T);
		$condition['bill_time'] = array('between',array($start_time,$end_time));
		
		$condition['project_id'] = $house["project_id"];
		$condition['building'] = $house["building"];
		$condition['room_number'] = $house["room_number"];
		
		$result = $bill_T->field("bill_id,bill_title,bill_price,bill_time,status")->where($condition)->order('add_time desc')->select();
		foreach($result as $k => $v){
			$result[$k]["bill_time"] = ststamp($result[$k]["bill_time"],"Y-m-d");
		}
		
		$this->assign('bill_list',$result);
		$content = $this->fetch('bill_list');
		
		$r = array("content" =>$content);
		echo(json_encode($r));
	}
	
	public function confirm_pay(){
		$bill_id = I('get.bill_id',"");
		$this->assign('bill_id',$bill_id);
		$bill_id = explode(",",$bill_id);		
		
		//读取用户余额
		import("Common.Common.Mxmember");
		$Mxmember = new \Mxmember();
		$info = json_decode($Mxmember->memberinfo(session("token")),true);
		$this->assign('money',$info["data"]["money"]);
		
		//var_dump(session("token"));
		
		$total = 0;
		$bill = array();
		foreach($bill_id as $k => $v){
			$bill[$v] = M($this->T)->where("bill_id=%d",$v)->field('bill_title,bill_price,status')->find();
			$total += $bill[$v]["bill_price"];
		}
		$this->assign('total',$total);
		
		$this->assign('recharge',sprintf("%.2f", $total-$info["data"]["money"]));
		
		$project_id = Check::get_project_id();
		$project = M("project")->where("h_id=%d",$project_id)->find();
		$this->assign('project',$project);
		$this->display();		
	}
	
	public function to_pay(){
		$bill_id = I('get.bill_id',"");
		$bill_id = explode(",",$bill_id);
		
		$is_back = I('get.is_back',0,"int");//充值返回
		
		
		
		//读取用户余额
		import("Common.Common.Mxmember");
		$Mxmember = new \Mxmember();
		$info = json_decode($Mxmember->memberinfo(session("token")),true);
		
		//var_dump($info);
		
		$total = 0;
		$bill = array();
		foreach($bill_id as $k => $v){
			$bill[$v] = M($this->T)->where("bill_id=%d",$v)->field('bill_title,bill_price,status')->find();
			$total += $bill[$v]["bill_price"];
		}
		
		//金额不足，跳转充值
		if($total>$info["data"]["money"]){
			$err = array("err"=>2,"msg"=>$is_back?$this->LANG['err_backnomoney']:$this->LANG['err_nomoney'],"money"=>sprintf("%.2f", $total-$info["money"]),"bill_id" => implode(",",$bill_id));
			echo(json_encode($err));
			exit();
		}
		
		//读取物业账号的uin
		$project_id = Check::get_project_id();
		$Boss_uin = M("project")->where("h_id=%d",$project_id)->getField('boss_uin');
		//获取ip
		$user_ip = get_client_ip();
		$uid = session("uin");
		
		$Mxmember = new \Mxmember();
		
		//分订单提交
		$err_id = array();
		foreach($bill_id as $k => $v){
			if($bill[$v]["status"] != 0){
				$err_id[] = $v;
			}
			else{
				$info = json_decode($Mxmember->shop_del_money($uid,$bill[$v]["bill_price"],$Boss_uin,$total,$bill[$v]["bill_title"],$this->LANG["pay_remark"],$user_ip),true);
				if($info["status"] == 1){
					$data = array();
					$data["status"] = 1;
					$data["pay_time"] = gtstamp();
					M($this->T)->where("bill_id=%d",$v)->save($data);
				}
				else{
					$err_id[] = $v;
				}
			}
		}
		
		if(empty($err_id)){
			$err = array("err"=>0,"msg"=>$this->LANG["pay_ok"]);
			echo(json_encode($err));
			exit();
		}
		else{
			$err = array("err"=>1,"msg"=>sprintf($this->LANG["err_pay"], implode(",",$err_id)));
			echo(json_encode($err));
			exit();
		}
	}
	
	public function to_pay_html(){
		$bill_id = I('get.bill_id',"");
		$this->assign('bill_id',$bill_id);
		$this->display();
	}
	
	public function change_house(){
		//import("Common.Common.Bdata");
		//$Bdata = new \Bdata();
		//$User_house = $Bdata->get_house(session("basic_id"));
		$User_house = Check::get_house(session("uin"),session("basic_id"),Check::get_project_id());
		
		$this->assign('house_list',$User_house);
		$this->display();
	}
}