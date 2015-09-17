<?php
namespace Admin\Controller;
use Think\Controller;
class MenuTreeController extends Controller {
	
	protected $Menu;	
	public function __construct(){
		$this->Menu = array(
			0 => array(
				"name"=>"通知资讯",
				"url"=>C("DOMAIN").U("Admin/Notice/index"),
			),
			1 => array(
				"name"=>"账单信息",
				"url"=>C("DOMAIN").U("Admin/Bill/index"),
			),
			2 => array(
				"name"=>"黄页信息",
				"url"=>C("DOMAIN").U("Admin/Yellow/index"),
			),
			3 => array(
				"name"=>"服务信息",
				"url"=>C("DOMAIN").U("Admin/Server/index"),
			),
			4 => array(
				"name"=>"闲置信息",
				"url"=>C("DOMAIN").U("Admin/Idle/index"),
			),
			5 => array(
				"name"=>"拼车信息",
				"url"=>C("DOMAIN").U("Admin/Carpool/index"),
			),
			/* 6 => array(
				"name"=>"我有子菜单哦",
				"url"=>C("DOMAIN").U("Admin/Carpool/index"),
				"sub" => array(
					0 => array(
						"name"=>"通知资讯",
						"url"=>C("DOMAIN").U("Admin/Notice/index"),
					),
					1 => array(
						"name"=>"账单信息",
						"url"=>C("DOMAIN").U("Admin/Bill/index"),
					),
					2 => array(
						"name"=>"黄页信息",
						"url"=>C("DOMAIN").U("Admin/Yellow/index"),
					),
					3 => array(
						"name"=>"服务信息",
						"url"=>C("DOMAIN").U("Admin/Server/index"),
					),
					4 => array(
						"name"=>"闲置信息",
						"url"=>C("DOMAIN").U("Admin/Idle/index"),
					),
				)
			), */
			99 => array(
				"name"=>"物业配置",
				"url"=>C("DOMAIN").U("Admin/Project/index"),
			),
		
		);	
    }
	
    public function index(){
		$this->ajaxReturn($this->Menu,"jsonp");
	}
}