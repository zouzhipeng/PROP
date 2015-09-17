<?php

	/**
	 * 操作记录
	 *
	 * @param int $site 站点id
	 * @param string $remark 备注
	 * @param string $data 相关数据
	 * @param int $type 记录类型  0,普通记录 1，失败记录
	 * @param string $url 记录页面
	 */
	function tolog($site, $remark="", $data="", $type=0, $url=""){
		$log_data['site'] = $site;
		$log_data['remark'] = $remark;
		$log_data['data'] = $data;
		$log_data['add_time'] = gtstamp();
		$log_data['url'] = $url;
		$log_data['type'] = $type;
		
		$filename = __DIR__.'\\..\\..\\log\\'.$site.'\\'.date("Y")."\\".date("m");
		if (!file_exists($filename)){ mkdir ($filename,0777,true);}
		$filename .= "\\".date("Y-m-d").".txt";
		file_put_contents($filename, json_encode($log_data).PHP_EOL,FILE_APPEND);


		// $log_T = M("log");// 实例化log对象
		// $log_T->data($log_data);
		// if($log_T->create($log_data)){
			// $log_T->add(); // 写入数据到数据库
		// }
	}


	/**
	 * 获取选项
	 *
	 * @param string $name 字段名
	 * @param string $table 表名
	 * @param string $field 字段名
	 * @return array
	 */
	function get_option($name = "", $table = "", $field = ""){
		$option_M = M("select_option");
		$option = array();
		if(!empty($name)) $condition['name'] = $name;
		if(!empty($table)) $condition['table'] = $table;
		if(!empty($field)) $condition['field'] = $field;
		if(!empty($condition)){
			//获取返回信息
			$result = $option_M->where($condition)->select();

			if($result){
				foreach($result as $row){
					$vl = unserialize($row["value"]);
					foreach($vl as $key => $v){
						$option[strtolower($row["field"])][$key] = $v;
					}
				}
			}
		}
		return $option;
	}
	
	/**
	 * 获取选项
	 *
	 * @param string $name 字段名
	 * @param string $table 表名
	 * @param string $field 字段名
	 * @return array
	 */
	function get_option_and_name($name = "", $table = "", $field = ""){
		$option_M = M("select_option");
		$option = array();
		if(!empty($name)) $condition['name'] = $name;
		if(!empty($table)) $condition['table'] = $table;
		if(!empty($field)) $condition['field'] = $field;
		if(!empty($condition)){
			//获取返回信息
			$result = $option_M->where($condition)->select();

			if($result){
				foreach($result as $row){
					$option[strtolower($row["field"])]["name"] = $row["name"];
					$vl = unserialize($row["value"]);
					foreach($vl as $key => $v){
						$option[strtolower($row["field"])]["option"][$key] = $v;
					}
				}
			}
		}
		return $option;
	}
	
	/**
	 * 获取字段值
	 *
	 * @param string $name 字段名
	 * @param string $table 表名
	 * @param string $field 字段名
	 * @param string $text 名
	 * @return 选项值
	 */
	function get_option_value($text, $name = "", $table = "", $field = ""){
		if(empty($text)) return $text;
		$option_M = M("select_option");
		$option = array();
		if(!empty($name)) $condition['name'] = $name;
		if(!empty($table)) $condition['table'] = $table;
		if(!empty($field)) $condition['field'] = $field;
		if(!empty($condition)){
			//获取返回信息
			$result = $option_M->where($condition)->getField("value");
			if($result){
				$vl = unserialize($result);
				foreach($vl as $key => $v){
					if($v == $text) return $key;
				}
			}
		}
		return $text;
	}
	
	/**
	 * 获取字段值和选项
	 *
	 * @param string $name 字段名
	 * @param string $table 表名
	 * @param string $field 字段名
	 * @param string $text 名
	 * @return 选项值
	 */
	function get_option_array($text, $name = "", $table = "", $field = ""){
		if(empty($text)) return $text;
		$option_M = M("select_option");
		$option = array();
		if(!empty($name)) $condition['name'] = $name;
		if(!empty($table)) $condition['table'] = $table;
		if(!empty($field)) $condition['field'] = $field;
		if(!empty($condition)){
			//获取返回信息
			$result = $option_M->where($condition)->getField("value");
			if($result){
				$vl = unserialize($result);
				foreach($vl as $key => $v){
					if($v == $text){
						$text = $key;
						break;
					}
				}
			}
		}
		return array("value" => $text,"option" => $vl);
	}
	
	/**
	 * 获取字段文本
	 *
	 * @param string $name 字段名
	 * @param string $table 表名
	 * @param string $field 字段名
	 * @param string $text 名
	 * @return 选项值
	 */
	function get_option_text($field_id,$field_value_id){
		$return = M("select_option")->where("field=%d",$field_id)->find();
		if($return){
			$option_value = unserialize($return["value"]);
			if(isset($option_value[$field_value_id])) return $option_value[$field_value_id];
		}
		return $field_value_id;	
	}
	

	/**
	 * 获取地区名
	 *
	 * @param int $id 地区id
	 * @return string
	 */
	function get_region_name($id){
		if(empty($id))
			return;
		$region = M("region")->where('region_id="'.$id.'"')->getField('name');
		return empty($region)?$id:$region;
	}
	/**
	 * 获取地区id
	 *
	 * @param string $id 地区名
	 * @return string
	 */
	function get_region_id($name){
		if(empty($name))
			return;
		$region = M("region")->where('name="'.$name.'"')->getField('region_id');
		return empty($region)?$name:$region;
	}
	/**
	 * zonecode获取地区数组
	 *
	 * @param string $zonecode 地区行政编号
	 * @return string
	 */
	function zonecode_to_region($zonecode){
		if(empty($zonecode))
			return;
		$region = M("region")->where('zonecode="%s"',array($zonecode))->getField('region_id');
		return empty($region)?$name:$region;
	}


	 /**
	 * 获取当前时间戳
	 *
	 * @param string $time 时间字符串，若无则返回当前时间
	 * @return string
	 */
	 function gtstamp($time = '') {
		if(empty($time)){
			return (time() - date('Z'));
		}
		elseif(is_numeric($time)){
			return (intval($time) - date('Z'));
		}
		else{
			return (strtotime($time) - date('Z'));
		}
	 }

	 /**
	 * 时间戳转时间字符串
	 *
	 * @param string $time 时间戳数字
	 * @return string
	 */
	 function ststamp($time,$format = 'Y-m-d H:i:s') {
		if(is_numeric($time)){
			return date($format,$time + date('Z'));
		}
		else{
			return "";
		}
	 } 

	 
	 /**
	 * 获取以提供时间的天的区间范围，供查询
	 *
	 * @param string $time 时间字符串
	 * @return array
	 */
	 function gtdaystamp($time) {
		if(is_numeric($time)){
			$thisdate = date('Y-m-d H:i:s',$time + date('Z'));

		}
		else{
			$thisdate = strtotime($time);
		}
		$day_1 = gtstamp(mktime(0,0,0,date('m',$thisdate), date('d',$thisdate),date('Y',$thisdate)));
		$day_2 = gtstamp(mktime(0,0,0,date('m',$thisdate), (date('d',$thisdate)+1),date('Y',$thisdate)));
		return array(array('gt',$day_1),array('lt',$day_2));

	 } 
 ?>
