<?php
namespace Admin\Controller;
use Think\Controller;
class BillController extends Controller {
	
	public function _initialize(){
		require(APP_PATH.'Admin/Language/'.C('Lang').'/Bill.php');//载入语言类
		Check::check();
		$this->T = "bill";
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
		$bill_T = M($this->T);
		
		$project_id = I("request.project_id",0,"int");
		$status = I("request.status",-1,"int");
		$this->assign('status',$status);
		
		
		//获取查询条件
		$page = I("request.page",1);
		$pagesize = I("request.pagesize",15);
		
		if($project_id > 0){
			$condition['n.project_id'] = $project_id;
		}
		else{
			$condition['n.project_id'] = array("in",implode(session("project_list"),","));
		}
		if($status >= 0){
			$condition['status'] = $status;
		}
		
		$bill_T->alias('n')->join('LEFT JOIN __PROJECT__ p ON n.project_id = p.h_id');
		$bill_T->field("bill_id,bill_title,bill_price,building,room_number,bill_time,pay_time,add_time,status,p.project");
		$result = $bill_T->where($condition)->order('bill_id desc')->limit(($page-1)*$pagesize,$pagesize)->select();
		
		$count = M($this->T)->alias('n')->where($condition)->count();
		
		// 更新时间值
		foreach($result as $k => $v){
			$result[$k]["add_time"] = ststamp($result[$k]["add_time"],'Y-m-d');
			$result[$k]["pay_time"] = ststamp($result[$k]["pay_time"],'Y-m-d');
			$result[$k]["bill_time"] = ststamp($result[$k]["bill_time"],'Y-m-d');
			$result[$k]["bill_address"] = $result[$k]["project"].$result[$k]["building"].$this->LANG['unit_building'].$result[$k]["room_number"].$this->LANG['unit_room_number'];			
		}
		//var_dump($result);
		
		$this->assign('list',$result);
		$content = $this->fetch('search_table');
		$r = array("content" =>$content,"count"=>$count,"page"=>$page,"pagesize"=>$pagesize);
		echo(json_encode($r));

	}
	
	public function bill_add(){
		if(IS_POST){
			$bill_title = I("request.bill_title","");
			$project_id = I("request.project_id",0,"int");
			$building = I("request.building","");
			$room_number = I("request.room_number","");
			$bill_time = I("request.bill_time","");
			$bill_price = I("request.bill_price",0,"float");
			$remarks = I("request.remarks","");
			
			//数据检查
			$err = array("err"=>0,"msg"=>"");
			if(empty($bill_title)){
				$err = array("err"=>1,"msg"=>$this->LANG['err_notitle']);
			}
			if($project_id <= 0){
				$err = array("err"=>1,"msg"=>$this->LANG['err_noprojectid']);
			}
			if(empty($building)){
				$err = array("err"=>1,"msg"=>$this->LANG['err_nobuilding']);
			}
			if(empty($room_number)){
				$err = array("err"=>1,"msg"=>$this->LANG['err_noroomnumber']);
			}
			if(empty($bill_time)){
				$err = array("err"=>1,"msg"=>$this->LANG['err_nobilltime']);
			}
			if($bill_price<=0){
				$err = array("err"=>1,"msg"=>$this->LANG['err_nobillprice']);
			}
			if($err["err"] == 1){
				echo(json_encode($err));
				exit();
			}
			
			//检查项目权限
			$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
			if(!$result){
				echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
				exit();
			}
			
			$bill_T = M($this->T);
			$data = array();
			$data['bill_title'] = $bill_title;
			$data['bill_price'] = $bill_price;
			$data['project_id'] = $project_id;
			$data['building'] = $building;
			$data['room_number'] = $room_number;
			$data['bill_time'] = gtstamp($bill_time);
			$data['add_time'] = gtstamp();
			$data['remarks'] = $remarks;
			$result = $bill_T->data($data)->add();
			
			if($result){
				echo(json_encode(array("err"=>0,"msg"=>$this->LANG['ok'])));
				exit();	
			}
			else{
				echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err'])));
				exit();	
			}
			
		}else{
			$manager_T = M('project_manager');
			$condition['m.uin'] = session("uin");
			
			$result = $manager_T->alias('m')->join('INNER JOIN __PROJECT__ p ON m.project_id = p.h_id')->field("p.h_id,p.project")->where($condition)->select();
			
			$this->assign('project_list',$result);
			$this->assign('now',date('Y-m-d H:i',time()));
			
			$this->display();
		}
	}
	
	public function bill_edit(){
		if(IS_POST){
			$bill_id = I("request.bill_id",0,"int");
			$bill_title = I("request.bill_title","");
			$project_id = I("request.project_id",0,"int");
			$building = I("request.building","");
			$room_number = I("request.room_number","");
			$bill_time = I("request.bill_time","");
			$bill_price = I("request.bill_price",0,"float");
			$remarks = I("request.remarks","");
			
			//数据检查
			$err = array("err"=>0,"msg"=>"");
			if($bill_id <= 0){
				$err = array("err"=>1,"msg"=>$this->LANG['err_nobillid']);
			}
			if(empty($bill_title)){
				$err = array("err"=>1,"msg"=>$this->LANG['err_notitle']);
			}
			if($project_id <= 0){
				$err = array("err"=>1,"msg"=>$this->LANG['err_noprojectid']);
			}
			if(empty($building)){
				$err = array("err"=>1,"msg"=>$this->LANG['err_nobuilding']);
			}
			if(empty($room_number)){
				$err = array("err"=>1,"msg"=>$this->LANG['err_noroomnumber']);
			}
			if(empty($bill_time)){
				$err = array("err"=>1,"msg"=>$this->LANG['err_nobilltime']);
			}
			if($bill_price<=0){
				$err = array("err"=>1,"msg"=>$this->LANG['err_nobillprice']);
			}
			if($err["err"] == 1){
				echo(json_encode($err));
				exit();
			}
			
			//检查项目权限
			$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
			if(!$result){
				echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
				exit();
			}
			
			$bill_T = M($this->T);
			$condition = array();
			$condition['bill_id'] = $bill_id;
			$condition['status'] = 0;
			$data = array();
			$data['bill_title'] = $bill_title;
			$data['bill_price'] = $bill_price;
			$data['project_id'] = $project_id;
			$data['building'] = $building;
			$data['room_number'] = $room_number;
			$data['bill_time'] = gtstamp($bill_time);
			$data['add_time'] = gtstamp();
			$data['remarks'] = $remarks;
			$result = $bill_T->where($condition)->save($data);
			
			if($result){
				echo(json_encode(array("err"=>0,"msg"=>$this->LANG['ok'])));
				exit();	
			}
			else{
				echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err'])));
				exit();	
			}
		}
		else{
			$bill_id = I("request.bill_id",0,"int");
			$result = M($this->T)->where("bill_id=%d",$bill_id)->find();
			if($result){
				//检查project_manager权限
				$r = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$result["project_id"]))->count();
				if(!$r){
					die($this->LANG['err_noprojectid']);
				}
			}
			else{
				die($this->LANG['err_yellowid']);
			}
			//echo($result["bill_time"]."|".ststamp($result["bill_time"],'Y-m-d H:i'));
			$result["bill_time"] = ststamp($result["bill_time"],'Y-m-d H:i');
			
			$this->assign('info',$result);

			
			$manager_T = M('project_manager');
			$condition['m.uin'] = session("uin");
			$result = $manager_T->alias('m')->join('INNER JOIN __PROJECT__ p ON m.project_id = p.h_id')->field("p.h_id,p.project")->where($condition)->select();
			$this->assign('project_list',$result);

			$this->display();
		}
	}
}