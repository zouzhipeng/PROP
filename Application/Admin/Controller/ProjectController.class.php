<?php
namespace Admin\Controller;
use Think\Controller;
class ProjectController extends Controller {
	public function _initialize(){
		require(APP_PATH.'Admin/Language/'.C('Lang').'/Project.php');//载入语言类
		Check::check();
		$this->T = "project";
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
			
			$menu = M('menu')->select();
			$this->assign('menu',$menu);
			
			$project = M('project')->where("h_id=%d",$project_id)->find();
			if($project){
				$project["project_menu"] = unserialize($project["project_menu"]);
			}
			$this->assign('project',$project);
			
			
			$this->assign('config',unserialize($project["project_config"]));
			
		}
		/* $m = array(
			3 => array(
				menu_name => "账单",
				menu_url => "/Prop/Bill/index.html",
				menu_ico => "icon-money",
			),
			8 => array(
				menu_name => "黄页",
				menu_url => "/Prop/Yellow/index.html",
				menu_ico => "icon-file-text-o",
			),
			1 => array(
				menu_name => "资讯",
				menu_url => "/Prop/Notice/index.html",
				menu_ico => "icon-bullhorn",
			),
		);
		echo(serialize($m)); */
		$this->display();
	}
	public function batch_menu(){
		$menu_list = M('project')->getField('h_id,project_menu',true);
		foreach($menu_list as $k => $v){
			$menu = unserialize($v);
			$menu_config = array();
			foreach($menu as $mk => $mv){
				$r = M('menu')->where(array("menu_id"=>$mk))->find();
				if($r){
					$menu_config[$v] = array(
						"menu_name" => $r["menu_name"],
						"menu_url" => $r["menu_url"],
						"menu_ico" => $r["menu_ico"],
						"menu_table" => $r["menu_table"],
					);
				}
				$result = M('project')->where(array("h_id"=>$k))->data(array("project_menu"=>serialize($menu_config)))->save();
			}			
		}
		
	}
	
	public function update_menu(){
		$project_id = I("request.project_id",0,"int");
		$menu_id = I("request.menu_id","");
		
		if($project_id <= 0){
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
			exit();
		}
		
		if(empty($menu_id)){
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_nomenuid'])));
			exit();
		}
		
		//检查project_manager权限
		$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
		if(!$result){
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
			exit();
		}
		
		$menu_id = explode(",",$menu_id);
		
		$menu_config = array();
		foreach($menu_id as $k => $v){
			$r = M('menu')->where(array("menu_id"=>$v))->find();
			if($r){
				$menu_config[$v] = array(
					"menu_name" => $r["menu_name"],
					"menu_url" => $r["menu_url"],
					"menu_ico" => $r["menu_ico"],
					"menu_table" => $r["menu_table"],
				);
			}
		}
		
		$result = M('project')->where(array("h_id"=>$project_id))->data(array("project_menu"=>serialize($menu_config)))->save();
		
		$err = array("err"=>0,"msg"=>$this->LANG["ok"].serialize($menu_config));
		echo(json_encode($err));
	}
	
	public function update_project(){
		$project_id = I("request.project_id",0,"int");
		$project_name = I("request.project_name","");
		$project_address = I("request.project_address","");
		$project_tel = I("request.project_tel","");
		
		if($project_id <= 0){
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
			exit();
		}
		
		//检查project_manager权限
		$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
		if(!$result){
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
			exit();
		}
		$data = array();
		$data["project_name"] = $project_name;
		$data["project_address"] = $project_address;
		$data["project_tel"] = $project_tel;
		$result = M('project')->where(array("h_id"=>$project_id))->data($data)->save();
		
		$err = array("err"=>0,"msg"=>$this->LANG["ok"]);
		echo(json_encode($err));
	}
	
	public function updata_config(){
		import("Common.Common.Qiniu");
		$Qiniu = new \Qiniu();
		
		$project_id = I("request.project_id",0,"int");
		$project_info = M('project')->where(array("h_id"=>$project_id))->find();
		$project_config = unserialize($project_info["project_config"]);

		$lucky_link = I("request.lucky_link","");
		$novice = I("request.novice","");
		$slides_url_0 = I("request.slides_url_0","");
		$slides_url_1 = I("request.slides_url_1","");
		$slides_url_2 = I("request.slides_url_2","");
		$slides_file_0 = !empty($_FILES["slides_file_0"]['tmp_name'])?$Qiniu->putFile($_FILES["slides_file_0"]):$project_config["slides"][0]["file"];
		$slides_file_1 = !empty($_FILES["slides_file_1"]['tmp_name'])?$Qiniu->putFile($_FILES["slides_file_1"]):$project_config["slides"][1]["file"];
		$slides_file_2 = !empty($_FILES["slides_file_2"]['tmp_name'])?$Qiniu->putFile($_FILES["slides_file_2"]):$project_config["slides"][2]["file"];
		
		$data["lucky_link"] = $lucky_link;
		$data["novice"] = $novice;
		$data["slides"] = array(
			0 => array(
				"file" => $slides_file_0,
				"url" => $slides_url_0,
			),
			1 => array(
				"file" => $slides_file_1,
				"url" => $slides_url_1,
			),
			2 => array(
				"file" => $slides_file_2,
				"url" => $slides_url_2,
			),
		);
		
		$result = M('project')->where(array("h_id"=>$project_id))->data(array("project_config"=>serialize($data)))->save();
		
		$this->redirect("Admin/Project/index/project_id/".$project_id);
	}
}