<?php
namespace Event\Controller;
class Event_C
{
	
	public function add($data){
		$err = array('type'=>0,'msg'=>'');
		if(!isset($data["event_name"])) $err = array('type'=>1,'msg'=>'活动名不能为空');
		if(!isset($data["event_type"])) $err = array('type'=>1,'msg'=>'活动分类不能为空');
		
		echo("hhhhhhhhhh");
	}
}