<?php
namespace Prop\Controller;
use Think\Controller;
class MyController extends Controller {
	
	public function _initialize(){
		Check::check();
   }	
	
    public function index(){
		$this->display();
	}
	
	public function my_house(){
		$User_house = Check::get_house(session("uin"),session("basic_id"),Check::get_project_id());
		
		$this->assign('house_list',$User_house);
		$this->display();
	}
}

