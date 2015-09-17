<?php
require './Public/vendor/autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;


class Qiniu {
	
	protected $APP_ACCESS_KEY;
	protected $APP_SECRET_KEY;
	protected $BUCKET;
	protected $DOMAIN;
	protected $EXT_ARR;
	protected $MAX_SIZE = 1000000;
	
	public  function __construct(){

        $this->APP_ACCESS_KEY = C('QINIU_CONFIG.APP_ACCESS_KEY');
		$this->APP_SECRET_KEY = C('QINIU_CONFIG.APP_SECRET_KEY');
		$this->BUCKET = C('QINIU_CONFIG.BUCKET');
		$this->DOMAIN = C('QINIU_CONFIG.DOMAIN');
		$this->EXT_ARR = array(
				'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
				'flash' => array('swf', 'flv'),
				'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
				'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
			);
    }
	
	
	/*
    * �ϴ��ļ�
    */

    public function putFile($file){
		if (empty($file) === false) {
		
			//ԭ�ļ���
			$file_name = $file['name'];
			//����������ʱ�ļ���
			$tmp_name = $file['tmp_name'];
			//�ļ���С
			$file_size = $file['size'];
			
			//����ļ���չ��
			$temp_arr = explode(".", $file_name);
			$file_ext = array_pop($temp_arr);
			$file_ext = trim($file_ext);
			$file_ext = strtolower($file_ext);
			
			//����ļ�����
			$file_type = $this->file_type($file_ext);
			
			
			if($file_type == false){
				return false;
			}
			if($file_size > $this->MAX_SIZE){
				return false;
			}
			
			//����·��
			$save_url = $file_type."/".date("Ymd") . "/";
			//���ļ���
			$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
			
			//�ƶ��ļ�����ţ
			$auth = new Auth($this->APP_ACCESS_KEY, $this->APP_SECRET_KEY);
			$token = $auth->uploadToken($this->BUCKET);
			$uploadManager = new UploadManager();
			
			list($ret, $err) = $uploadManager->putFile($token, "$save_url$new_file_name", $tmp_name);

			if ($err != null)
				return false;
			return $this->DOMAIN.$ret["key"];
		}
		else{
			return false;
		}
    }
	
	
	/*
    * ȡ���ļ�����
    */

    public function file_type($file_ext){
		foreach($this->EXT_ARR as $k => $v){
			if(in_array($file_ext,$v))
				return $k;
		}
		return false;
    }
}