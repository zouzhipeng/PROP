<?php
namespace Admin\Controller;
use Think\Controller;
class YellowController extends Controller {
	
	public function _initialize(){
		require(APP_PATH.'Admin/Language/'.C('Lang').'/Yellow.php');//载入语言类
		Check::check();
		$this->T = "yellow";
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
			
			$yellow_T = M($this->T);
			
			$condition = array();
			$condition['project_id'] = $project_id;
			$condition['yellow_parent'] = 0;
			$result = $yellow_T->field("yellow_id,yellow_name,yellow_have_child")->where($condition)->select();
			$this->assign('rank_0',$result);
		}
		$this->display();
	}
	
	public function yellow_list(){
		$yellow_parent = I("request.yellow_parent",0,"int");
		$project_id = I("request.project_id",0,"int");
		
		$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
		if(!$result){
			echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
			exit();
		}
		
		
		$yellow_T = M($this->T);
		
		$condition = array();
		$condition['project_id'] = $project_id;
		$condition['yellow_parent'] = $yellow_parent;
		$result = $yellow_T->field("yellow_id,yellow_name,yellow_have_child")->where($condition)->select();

		echo(json_encode(array("err"=>0,"list"=>$result)));
		exit();		
	}
	
	public function yellow_add(){
		if(IS_POST){
			$yellow_name = I("request.yellow_name","");
			$yellow_phone = I("request.yellow_phone","");
			$project_id = I("request.project_id",0,"int");
			$yellow_address = I("request.yellow_address","");
			$yellow_describe = I("request.yellow_describe","");
			$yellow_parent = I("request.yellow_parent",0,"int");
			
			//检查project_manager权限
			$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$project_id))->count();
			if(!$result){
				echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noprojectid'])));
				exit();
			}
			
			$yellow_T = M($this->T);
			
			//获得$yellow_rank
			$yellow_rank = 0;
			if($yellow_parent != 0){
				//检查$yellow_parent
				$parent = $yellow_T->where("yellow_id=%d",$yellow_parent)->find();
				if(!$parent){
					echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err_noparentid'])));
					exit();
				}
				$yellow_rank = $parent["yellow_rank"]+1;
			}
			
			$data = array();
			$data['yellow_name'] = $yellow_name;
			$data['yellow_phone'] = $yellow_phone;
			$data['yellow_address'] = $yellow_address;
			$data['yellow_describe'] = $yellow_describe;
			$data['yellow_parent'] = $yellow_parent;
			$data['yellow_rank'] = $yellow_rank;
			$data['project_id'] = $project_id;
			$result = $yellow_T->data($data)->add();
			
			if($result){
				//更新父黄页的yellow_have_child值
				$count = $yellow_T->where("yellow_parent=%d",$yellow_parent)->count();
				$yellow_T-> where("yellow_id=%d",$yellow_parent)->setField('yellow_have_child',$count);
				
				echo(json_encode(array("err"=>0,"msg"=>$this->LANG['ok'],"rank"=>$yellow_rank)));
				exit();	
			}
			else{
				echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err'])));
				exit();	
			}
		}
		else{
			$yellow_parent = I("request.yellow_parent",0,"int");
			$this->assign('yellow_parent',$yellow_parent);
			$project_id = I("request.project_id",0,"int");
			$this->assign('project_id',$project_id);
			
			$this->display();
		}		
	}
	
	public function yellow_edit(){
		if(IS_POST){
			$yellow_id = I("request.yellow_id",0,"int");
			$yellow_name = I("request.yellow_name","");
			$yellow_phone = I("request.yellow_phone","");
			$yellow_address = I("request.yellow_address","");
			$yellow_describe = I("request.yellow_describe","");
			
			$result = M($this->T)->where("yellow_id=%d",$yellow_id)->find();
			if($result){
				//检查project_manager权限
				$r = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$result["project_id"]))->count();
				if(!$r){
					return array("err"=>1,"msg"=>$this->LANG['err_noprojectid']);
				}
			}
			else{
				return array("err"=>1,"msg"=>$this->LANG['err_yellowid']);
			}
			
			$data = array();
			$data["yellow_id"] = $yellow_id;
			$data["yellow_name"] = $yellow_name;
			$data["yellow_phone"] = $yellow_phone;
			$data["yellow_address"] = $yellow_address;
			$data["yellow_describe"] = $yellow_describe;
			$s_result = M($this->T)->data($data)->save();
			
			if($s_result)
				echo(json_encode(array("err"=>0,"msg"=>$this->LANG['ok'],"yellow_parent"=>$result["yellow_parent"],"yellow_rank"=>$result["yellow_rank"])));
			else
				echo(json_encode(array("err"=>1,"msg"=>$this->LANG['err'])));						
		}
		else{
			$yellow_id = I("request.yellow_id",0,"int");
			$result = M($this->T)->where("yellow_id=%d",$yellow_id)->find();
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

			$this->assign('info',$result);
			$this->display();
		}
	}
	
	public function yellow_del(){
		$yellow_id = I("request.yellow_id",0,"int");
		
		$result = $this->do_del($yellow_id);
		
		echo(json_encode($result));
		exit();
		
	}
	
	public function do_del($yellow_id){
		$result = M($this->T)->where("yellow_id=%d",$yellow_id)->find();
		if($result){
			//检查project_manager权限
			$result = M('project_manager')->where(array("uin"=>session("uin"),"project_id"=>$result["project_id"]))->count();
			if(!$result){
				return array("err"=>1,"msg"=>$this->LANG['err_noprojectid']);
			}
			
			if($result["yellow_have_child"]>0){
				$del_list = M($this->T)->where("yellow_parent=%d",$yellow_id)->select();
				foreach($del_list as $k => $v){
					$r = $this->do_del($v["yellow_id"]);
					if($r["err"] == 1) return $r;
				}
			}
			
			M($this->T)->delete($yellow_id);
			
			return array("err"=>0,"msg"=>$this->LANG['ok']);
		}
		else{
			return array("err"=>1,"msg"=>$this->LANG['err_yellowid']);
		}
	}
	
}

