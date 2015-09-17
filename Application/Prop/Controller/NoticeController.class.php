<?php
namespace Prop\Controller;
use Think\Controller;
class NoticeController extends Controller {
	
	public function _initialize(){
		require(APP_PATH.'Prop/Language/'.C('Lang').'/Notice.php');//载入语言类
		Check::check();
		$this->T = "notice";
    }	
	
    public function index(){
		//echo(session("uin"));
		$project_id = Check::get_project_id();
		if(empty($project_id)){
			err_alert($this->LANG["err_noproject"],C("USER_API"));
		}
		
		//更新提醒时间
		$now_time = M($this->T)->where(array("project_id"=>$project_id))->max("add_time");
		Check::set_new_remind($this->T,$now_time);
		
		$notice_T = M($this->T);
		$condition['project_id'] = $project_id;
		$condition['notice_state'] = 1;
		$result = $notice_T->field("notice_id,notice_title,add_time,is_top")->where($condition)->order('is_top desc,notice_id desc')->select();
		
		$this->assign('project',Check::get_project());
		$this->assign('notice_list',$result);
		$this->display();
	}
	
	public function info(){
		$notice_id = I("get.notice_id",0,"int");
		$notice_T = M($this->T);
		$condition['notice_id'] = $notice_id;
		$condition['notice_state'] = 1;
		
		$result = $notice_T->field("notice_id,notice_title,notice_content,add_time")->where($condition)->find();
		$result["add_time"] = ststamp($result["add_time"]);
		
		$this->assign('info',$result);
		$this->display();
	}
	
}