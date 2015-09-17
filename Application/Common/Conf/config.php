<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => 'root', // 密码
	'DB_PREFIX' => 'prop_', // 数据库表前缀 'DB_DSN'    => 'mysql:host=localhost;dbname=thinkphp;charset=UTF-8'
	'DB_NAME'   => 'guanyu_property', // 数据库名
	'DB_CHARSET'   => 'utf8', // 数据库名
    'DEFAULT_MODULE'        => 'Prop',
    'DEFAULT_THEME'            => 'default',
	"URL_MODEL" => 2,
	//'LAYOUT_ON'=>true,
	'DOMAIN' => 'http://prop.zzp.cn', //站点域名
	'ENTRYDOMAIN' => 'http://www.center.com', //站点域名
	'SESSION_OPTIONS'=>array(
		'type'=> 'db',//session采用数据库保存
		'expire'=>1440,//session过期时间，如果不设就是php.ini中设置的默认值
	  ),
	'SESSION_TABLE'=>'session', //必须设置成这样，如果不加前缀就找不到数据表，这个需要注意
	
	'USER_API' => 'http://i.test.guanyu.cn/Public/login.html?redirect_url=',
	'REG_API' => 'http://i.test.guanyu.cn/Public/login.html?redirect_url=',
	'GET_TOKEN' => 'http://i.test.guanyu.cn/Public/login_auth.html?callback=?',
	'RECHARGE_API' => 'https://i.guanyu.cn/Pay/Public/pay_login.html?',//参数有money=%s&redirect_url=%s',
	'USER_GET_API'=>'http://i.test.guanyu.cn/Api/',
	'USER_CENTER'=>'http://i.test.guanyu.cn/',
	
	'HOUSE_API' => array( //房源列表获取地址
		'URL' => 'http://home.guanyu.cn/Api/House',
		'LEIXINGURL' => 'https://house.guanyu.cn/Master/Api/reg/property/2/prop_url/%s',
		),
	
	'MX_MEMBER' => array(
		'APP_KEYS' 	=> 'SQXCXGXDDYTXNXKJPVCYMZSRVAQZQFQWOGDTRKXRPIIAJGGVQXAOLNLDLVWBSZFH',
		'AUTH_CODE' => '',
		),
	'QINIU_CONFIG' => array(
		'APP_ACCESS_KEY' 	=> '9eDSWiB9WkYI3hR0wf86Yu0tnTssUCtm5z-HaG0d',
		'APP_SECRET_KEY' => 'SFTfvgsp8qZxdn6vd3KrJm3EpChtu0fNTF1widML',
		'BUCKET' => 'ceshi',
		'DOMAIN' => 'http://7xkyy5.com1.z0.glb.clouddn.com/',
		),
	'BDATA_CONFIG' => array(
		'SITE_KEY' 	=> '123',
		'SITE_ID' => '4',
		'APP_KEY' => '123',
		'URL' => 'http://api.test.user.guanyu.cn/',
		),
	//统计代码
	//'STATISTICAL_CODE' => '<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan style=\'display:none;\' id=\'cnzz_stat_icon_1255866071\'%3E%3C/span%3E%3Cscript src=\'" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1255866071\' type=\'text/javascript\'%3E%3C/script%3E"));</script>',
	'STATISTICAL_CODE' => '<div style="display:none;"><script src="http://s95.cnzz.com/z_stat.php?id=1255866071&web_id=1255866071" language="JavaScript"></script></div>',
);