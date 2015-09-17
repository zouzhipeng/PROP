<?php
// +----------------------------------------------------------------------
// | Author: Aminsire <aminsire@gmail.com>
// +----------------------------------------------------------------------
/** * 美象 用户数据类 */
class Mxmember {
	/**     * APP加密钥匙     */
	protected $appkeys;
	/**
     * 加密混合值
     */
	protected $auth_code;
	/**
     * API主机
     */
	protected $api_host;	
	public  function __construct(){
		header('Content-Type:application/json; charset=utf-8');
        $this->appkeys 		= C('MX_MEMBER.APP_KEYS');
        $this->auth_code 	= C('MX_MEMBER.AUTH_CODE');
        $this->api_host 	= C('USER_GET_API');
    }
	
	/*
    * 查询用户资料
    */
    public function member_info_data($uin){
        $apiurl = $this->api_host.'account/member_info_data.html';
        $data = array (
            'uin' => $uin
            );
        $return = $this->curl_file_get_contents($apiurl,$data);
        return $return;
    }
	//发货
	public function add_wuliu($u_keys,$price,$name,$phone,$sender,$address,$address2,$goods){
        $apiurl = 'http://feixiang.00797.com.cn/api/add_order.html';
        $data = array (
            'uin' => $u_keys,
            'price' => $price,
            'address' => $address,
            'name' => $name,
            'phone' => $phone,
            'sender' => $sender,
            'address2' => $address2,
            'goods' => $goods,
            'get_client_ip'=>get_client_ip()
            );

        $return = $this->curl_file_get_contents($apiurl,$data);

        return $return;
    }



	/**
 	* POST接口
 	*/
	function curl_file_get_contents($apiurl,$data){
		$data['appkeys'] = $this->appkeys;

    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $apiurl);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);				curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); //是否抓取跳转后的页面 
    	$return = curl_exec ($ch);
    	curl_close($ch);

    	return $return;
	}
	//扣款
	public function shop_del_money($uid,$money,$shopid,$totalprice,$title,$remark,$user_ip){
        $apiurl = $this->api_host.'account/shop_del_money.html';

        $data = array (
            'uid' => $uid,
            'money'    =>$money,
            'shop_uid'    =>$shopid,
            'totalprice'    =>$totalprice,
            'title'    =>$title,
            'remark'    =>$remark,
            'user_ip'    =>$user_ip
            );

        $return = $this->curl_file_get_contents($apiurl,$data);

        return $return;
    }

	/*
	* 登录验证
	*
	*/
	public function auth($phone,$password){

    	$apiurl = $this->api_host.'account/auth.html';


    	$data = array (
    		'phone' => $phone,
    		'password' => $password
    		);

    	$return = $this->curl_file_get_contents($apiurl,$data);
		
    	return $return;
	}

	/*
	* 查询用户信息
	*/
	public function memberinfo($token){
    	$apiurl = $this->api_host.'account/memberinfo.html';
    	$data = array (
    		'token' => $token
    		);
    	$return = $this->curl_file_get_contents($apiurl,$data);
		//print_r($return);
    	return $return;
	}		/*	* 查询用户信息	*/	public function get_token($token){    	$apiurl = C('GET_TOKEN');		print_r($apiurl);		$data = array();    	$return = $this->curl_file_get_contents($apiurl,$data);		//print_r($return);    	return $return;	}

	/*
	* 注册帐号
	*/
	public function register($phone,$password,$sms_verify_code){
    	$apiurl = $this->api_host.'account/register.html';
    	$data = array (
    		'phone' => $phone,
    		'password' => $password,
    		'sms_verify_code' => $sms_verify_code
    		);
    	$return = $this->curl_file_get_contents($apiurl,$data);
    	return $return;
	}

	/*
	* 检测用户是否存在
	*/
	public function phone_is($phone){
		$apiurl = $this->api_host.'account/phone_is.html';

    	$data = array (
    		'phone' => $phone
    		);

    	$return = $this->curl_file_get_contents($apiurl,$data);

    	return $return;
	}


	/*
	* 注册发送手机验证码
	*/
	public function register_phone_sms($phone,$key){
		$apiurl = $this->api_host.'account/register_phone_sms.html';

    	$data = array (
    		'phone' => $phone,
    		'key' 	 =>$key
    		);

    	$return = $this->curl_file_get_contents($apiurl,$data);

    	return $return;
	}

    /*
    * 增加积分
    */
    public function add_points($token,$points,$title,$remark,$user_ip){
        $apiurl = $this->api_host.'account/add_points.html';

        $data = array (
            'token' => $token,
            'points'    =>$points,
            'title'    =>$title,
            'remark'    =>$remark,
            'user_ip'    =>$user_ip
            );

        $return = $this->curl_file_get_contents($apiurl,$data);

        return $return;
    }

    /*
    * 减少积分
    */
    public function del_points($token,$points,$title,$remark,$user_ip){
        $apiurl = $this->api_host.'account/del_points.html';

        $data = array (
            'token' => $token,
            'points'    =>$points,
            'title'    =>$title,
            'remark'    =>$remark,
            'user_ip'    =>$user_ip
            );

        $return = $this->curl_file_get_contents($apiurl,$data);

        return $return;
        
    }

    /*
    * 增加金币
    */
    public function add_money($token,$money,$title,$remark,$user_ip){
        $apiurl = $this->api_host.'account/add_money.html';

        $data = array (
            'token' => $token,
            'money'    =>$money,
            'title'    =>$title,
            'remark'    =>$remark,
            'user_ip'    =>$user_ip
            );

        $return = $this->curl_file_get_contents($apiurl,$data);

        return $return;
    }

    /*
    * 增加金币
    */
    public function del_money($token,$money,$title,$remark,$user_ip){
        $apiurl = $this->api_host.'account/del_money.html';

        $data = array (
            'token' => $token,
            'money'    =>$money,
            'title'    =>$title,
            'remark'    =>$remark,
            'user_ip'    =>$user_ip
            );

        $return = $this->curl_file_get_contents($apiurl,$data);

        return $return;
    }

    /*
    * 发送短信
    */
    public function send_sms($phone,$message,$sign){
        $apiurl = $this->api_host.'account/send_sms.html';

        $data = array (
            'phone' => $phone,
            'message'    =>$message,
            'sign'    =>$sign
            );

        $return = $this->curl_file_get_contents($apiurl,$data);

        return $return;
    }



}