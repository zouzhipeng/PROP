<?php
namespace Prop\Controller;
use Think\Controller;
class NeighborController extends Controller {
	
	public function _initialize(){
		//require(APP_PATH.'Prop/Language/'.C('Lang').'/Notice.php');//����������
		Check::check();
		//$this->T = "notice";
    }	
	
    public function index(){
		$this->display();
	}
}