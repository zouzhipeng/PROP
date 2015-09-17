<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_USER'   => 'property_user', // 用户名
	'DB_PWD'    => 'zzp19840429', // 密码
	'DB_PREFIX' => 'prop_', // 数据库表前缀 'DB_DSN'    => 'mysql:host=localhost;dbname=thinkphp;charset=UTF-8'
	'DB_NAME'   => 'guanyu_property', // 数据库名
	'DB_CHARSET'   => 'utf8', // 数据库名
    'DEFAULT_MODULE'        => 'Prop',
    'DEFAULT_THEME'            => 'default',
	"URL_MODEL" => 2,
	//'LAYOUT_ON'=>true,
	'DOMAIN' => 'http://prop.guanyu.cn', //站点域名
	'ENTRYDOMAIN' => 'http://center.guanyu.com', //站点域名
	'SESSION_OPTIONS'=>array(
		'type'=> 'db',//session采用数据库保存
		'expire'=>1440,//session过期时间，如果不设就是php.ini中设置的默认值
	  ),
	'SESSION_TABLE'=>'session', //必须设置成这样，如果不加前缀就找不到数据表，这个需要注意
	
	'USER_API' => 'https://i.guanyu.cn/Public/login.html?redirect_url=',
	'REG_API' => 'https://i.guanyu.cn/Public/login.html?redirect_url=',
	'GET_TOKEN' => 'https://i.guanyu.cn/Public/login_auth.html?callback=?',
	'RECHARGE_API' => 'https://i.guanyu.cn/Pay/Public/pay_login.html?',//参数有money=%s&redirect_url=%s',
	'USER_GET_API'=>'https://i.guanyu.cn/Api/',
	'USER_CENTER'=>'https://i.guanyu.cn/',
	
	'HOUSE_API' => array( //房源列表获取地址
		'URL' => 'http://home.guanyu.cn/Api/House',
		'LEIXINGURL' => 'https://house.guanyu.cn/Master/Api/shenfengleixing/old_only/1',
		),
	
	'MX_MEMBER' => array(
		'APP_KEYS' 	=> 'KUGLDGYRHWVYVMRJPSJBBVUERRVAXEYHZFSCMRUTOPRJCJTRCDTDYOIPGDQDIPKH',
		'AUTH_CODE' => '',
		),
	'QINIU_CONFIG' => array(
		'APP_ACCESS_KEY' 	=> '9eDSWiB9WkYI3hR0wf86Yu0tnTssUCtm5z-HaG0d',
		'APP_SECRET_KEY' => 'SFTfvgsp8qZxdn6vd3KrJm3EpChtu0fNTF1widML',
		'BUCKET' => 'ceshi',
		'DOMAIN' => 'http://7xkyy5.com1.z0.glb.clouddn.com/',
		),
	'BDATA_CONFIG' => array(
		'SITE_KEY' 	=> '23a5b8ab834cb5140fa6665622eb6417',
		'SITE_ID' => '4',
		'APP_KEY' => '123',
		'URL' => 'http://api.user.guanyu.cn/',
		),
);