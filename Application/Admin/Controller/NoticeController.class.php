<?php
namespace Admin\Controller;
use Think\Controller;
class NoticeController extends Controller {
	
	public function _initialize(){
		require(APP_PATH.'Admin/Language/'.C('Lang').'/Notice.php');//载入语言类
		Check::check();
		$this->T = "notice";
    }	
	
    public function index(){
		//echo(session("uin"))."-----".session("project_list");
		$project_id = I("request.project_id",0,"int");
		$this->assign('project_id',$project_id);

		$manager_T = M('project_manager');
		$condition['m.uin'] = session("uin");
		$result = $manager_T->alias('m')->join('INNER JOIN __PROJECT__ p ON m.project_id = p.h_id')->field("p.h_id,p.project")->where($condition)->select();
		if($result){
			$this->assign('project_list',$result);
			
			//if($project_id <= 0)$project_id = $result[0]["h_id"];			
		}
		
		$this->display();
	}
	
	public function search(){
		$condition = array();		
		
		$notice_T = M($this->T);
		$project_id = I("request.project_id",0,"int");
		$notice_state = I("request.notice_state",-1,"int");
		$this->assign('notice_state',$notice_state);
		
		//获取查询条件
		$page = I("request.page",1);
		$pagesize = I("request.pagesize",15);
		
		if($project_id > 0){
			$condition['n.project_id'] = $project_id;
		}
		else{
			$condition['n.project_id'] = array("in",implode(session("project_list"),","));
		}
		if($notice_state >= 0){
			$condition['notice_state'] = $notice_state;
		}
		
		$result = $notice_T->alias('n')->join('LEFT JOIN __PROJECT__ p ON n.project_id = p.h_id')->field("notice_id,notice_title,add_time,notice_state,is_top,p.project")->where($condition)->order('is_top desc,notice_id desc')->limit(($page-1)*$pagesize,$pagesize)->select();
		$count = M($this->T)->alias('n')->where($condition)->count();
		
		// 更新时间值
		foreach($result as $k => $v){
			$result[$k]["add_time"] = ststamp($result[$k]["add_time"],'Y-m-d');		
		}
		
		$this->assign('list',$result);
		$content = $this->fetch('search_table');
		$r = array("content" =>$content,"count"=>$count,"page"=>$page,"pagesize"=>$pagesize);
		echo(json_encode($r));

	}
	
    public function notice_verify(){
		$notice_id = I("request.notice_id",1);	
		$project_id = M($this->T)->where(array("notice_id"=>$notice_id))->getField("project_id");
		
		//检查项目权限
		$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
		if(!$result){
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
			exit();
		}
		
		$notice_T = M($this->T);
		$condition['project_id'] = $project_id;
		$condition['notice_id'] = $notice_id;
		$condition['notice_state'] = 0;
		$result = $notice_T->where($condition)->setField('notice_state',1);
		if($result){
			echo(json_encode(array("err"=>0,"msg"=>$this->LANG['ok'])));
			exit();	
		}
		else{
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err'])));
			exit();	
		}
	}
	
	public function notice_add(){
		if(IS_POST){
			$notice_title = I("request.notice_title","");
			$notice_author = I("request.notice_author","");
			$notice_state = I("request.notice_state",0,"int");
			$project_id = I("request.project_id",0);
			$is_top = I("request.is_top",0);
			$notice_content = I("request.notice_content","");
			
			if(empty($notice_title) || $project_id <= 0){
				echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noadd'])));
				exit();
			}
			
			$notice_T = M($this->T);
			$data["notice_title"] = $notice_title;
			$data["notice_author"] = $notice_author;
			$data["notice_state"] = $notice_state;
			$data["project_id"] = $project_id;
			$data["is_top"] = $is_top;
			$data["notice_content"] = $notice_content;
			$data["add_time"] = gtstamp();
			
			$result = $notice_T->data($data)->add();
			if($result)
				echo(json_encode(array("err"=>0,"msg"=>$this->LANG['ok'])));
			else
				echo(json_encode(array("err"=>0,"msg"=>$this->LANG['err'])));			
		}else{
			$manager_T = M('project_manager');
			$condition['m.uin'] = session("uin");
			
			$result = $manager_T->alias('m')->join('INNER JOIN __PROJECT__ p ON m.project_id = p.h_id')->field("p.h_id,p.project")->where($condition)->select();
			
			$this->assign('project_list',$result);
			$this->display();
		}
	}
	
	public function notice_edit(){
		if(IS_POST){
			$notice_id = I("request.notice_id",0,"int");
			$notice_title = I("request.notice_title","");
			$notice_author = I("request.notice_author","");
			$notice_state = I("request.notice_state",0,"int");
			$project_id = I("request.project_id",0);
			$is_top = I("request.is_top",0);
			$notice_content = isset($_REQUEST["notice_content"])?$_REQUEST["notice_content"]:"";
			
			if($notice_id <0 || empty($notice_title) || $project_id <= 0){
				echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noadd'])));
				exit();
			}
			
			$notice_T = M($this->T);
			$data["notice_id"] = $notice_id;
			$data["notice_title"] = $notice_title;
			$data["notice_author"] = $notice_author;
			$data["notice_state"] = $notice_state;
			$data["project_id"] = $project_id;
			$data["is_top"] = $is_top;
			$data["notice_content"] = $notice_content;
			$data["add_time"] = gtstamp();
			
			$result = $notice_T->data($data)->save();
			if($result)
				echo(json_encode(array("err"=>0,"msg"=>$this->LANG['ok'])));
			else
				echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err'])));			
		}else{
			$notice_id = I("request.notice_id",0);
			if($notice_id<=0) return;			
			
			//物业账号名下项目
			$manager_T = M('project_manager');
			$condition['m.uin'] = session("uin");			
			$result = $manager_T->alias('m')->join('INNER JOIN __PROJECT__ p ON m.project_id = p.h_id')->field("p.h_id,p.project")->where($condition)->select();
			$this->assign('project_list',$result);
			
			//通知信息
			$notice_T = M($this->T);
			$result = $notice_T->where("notice_id=%d",$notice_id)->find();
			
			$this->assign('info',$result);
			$this->display();
		}
	}
	
	public function notice_del(){
		if(IS_POST){
			$notice_T = M($this->T);
			$notice_id = I("request.notice_id",0,"int");
			$result = $notice_T->delete($notice_id);
			if($result)
				echo(json_encode(array("err"=>0,"msg"=>$this->LANG['ok'])));
			else
				echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err'])));			
		}
	}
	
}