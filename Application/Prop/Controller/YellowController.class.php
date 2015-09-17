<?php
namespace Prop\Controller;
use Think\Controller;
class YellowController extends Controller {
	
	public function _initialize(){
		Check::check();
		$this->T = "yellow";
   }	
	
    public function index(){
		$project_id = Check::get_project_id();
		$this->assign('project',Check::get_project());
		
		$yellow_parent = I("get.yellow_parent",0,"int");
		
		$condition['project_id'] = $project_id;
		$condition['yellow_parent'] = $yellow_parent;
	
		$yellow_T = M($this->T);
		$result = $yellow_T->field("yellow_id,yellow_name,yellow_phone,yellow_parent,yellow_address,yellow_have_child")->where($condition)->order('order_id desc,yellow_id desc')->select();
		$this->assign('yellow_list',$result);
		
		$this->display();
	}
}

