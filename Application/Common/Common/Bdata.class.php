<?php

class Bdata {
	
	protected $SITE_KEY;
	protected $SITE_ID;
	protected $APP_KEY;
	protected $URL;
	
	
	public function __construct(){

        $this->SITE_KEY = C('BDATA_CONFIG.SITE_KEY');
        $this->SITE_ID = C('BDATA_CONFIG.SITE_ID');
        $this->APP_KEY = C('BDATA_CONFIG.APP_KEY');
        $this->URL = C('BDATA_CONFIG.URL');
    }
	
	public function get_user($uin = 0, $Basic_id = 0) {
		$url = $this->URL."API/Basic/basic_select/";
		$data = array();
		if($uin>0)$data["uin"] = $uin;
		if($Basic_id>0)$data["Basic_id"] = $Basic_id;
		if(empty($data)){
			return false;
		}
		else{
			$data["full"] = 1;
			return json_decode($this->curl_post($url,$this->format_key($data,empty($Basic_id)?$uin:$Basic_id)),true);
		}
	}
	
	public function get_house($Basic_id, $data = array()) {
		$url = $this->URL."API/House/house_select/";
		if($Basic_id>0)$data["Basic_id"] = $Basic_id;
		if(empty($data)){
			return false;
		}
		else{
			return json_decode($this->curl_post($url,$this->format_key($data,$Basic_id)),true);
		}
	}
	
	public function format_key($data,$Edit_user = "",$Edit_article = ""){
		$r = array();
		$r["appKey"] = $this->APP_KEY;
		$r["timestamp"] = time();
		$r["sign"] = MD5($this->APP_KEY.$r["timestamp"].$this->SITE_KEY);
		$r["data"] = json_encode($data);
		$r["site_id"] = $this->SITE_ID;
		$r["Edit_user"] = $Edit_user;
		$r["Edit_article"] = $Edit_article;
		return $r;
	}
	
	public function curl_post($url, $post) {
		/* $options = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER         => false,
			CURLOPT_POST           => true,
			CURLOPT_POSTFIELDS     => $post,
		);

		$ch = curl_init($url);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result; */
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);//解决 Problem (2) in the Chunked-Encoded data！！！
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); //是否抓取跳转后的页面 
    	$return = curl_exec ($ch);
    	curl_close($ch);
    	return $return;
	}
}