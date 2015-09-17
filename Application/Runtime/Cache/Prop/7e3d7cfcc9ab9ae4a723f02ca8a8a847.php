<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?php echo ($project); ?></title>
    <link rel="stylesheet" href="/Public/Prop/pintuer.css"/>
    <link rel="stylesheet" href="/Public/Prop/wuye.css"/>
    <link rel="stylesheet" href="/Public/Prop/iconfont.css">
    <script src="/Public/Prop/js/jquery.min.js"></script>
    <script src="/Public/Prop/js/TouchSlide.1.1.js"></script>
    <script src="/Public/Prop/js/pintuer.js"></script>
</head>
<body>
    <header class="padding bg-diy text-white text-center height clearfix">
        <div class="x3 text-left padding-left">
            <a href="<?php echo U('Prop/Index/d_register');?>" class="text-white text-little" style="line-height:12px;"> <i class="icon iconfont">&#xe613;</i> 代注册</a>
        </div>
        <h4 class="x6 text-center height web-font">
            <?php echo ($project); ?>
        </h4>
        
    </header>
    <div id="ad-banner">
        <div id="focus" class="focus">
            <div class="hd">
                <ul></ul>
            </div>
            <div class="bd">
                <ul>
                	<?php if(is_array($project_info["project_config"]["slides"])): $i = 0; $__LIST__ = $project_info["project_config"]["slides"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($item["url"]); ?>"><img _src="<?php echo ($item["file"]); ?>?imageView2/0/h/140" src="/Public/Prop/images/blank.png" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
        <script type="text/javascript">
            TouchSlide({
                slideCell:"#focus",
                titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
                mainCell:".bd ul",
                effect:"left",
                autoPlay:true,//自动播放
                autoPage:true, //自动分页
                switchLoad:"_src" //切换加载，真实图片路径为"_src"
            });
        </script>
    </div>
    <section class="index">
        <h5 class="padding text-gray">
            今天是<?php echo ($date_str); ?> <?php echo ($Ldate_str); ?>
        </h5>
        <nav class="clearfix text-center">
        	<?php if(is_array($project_info["project_menu"])): $i = 0; $__LIST__ = $project_info["project_menu"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><a href="<?php echo (sprintf($item["menu_url"],session('token'))); ?> " class="x3 margin-bottom">
                <i class="icon iconfont text-diysize <?php if($item["have_new"] == 1): ?>have_new<?php endif; ?>"><?php echo ($item["menu_ico"]); ?></i>
                <div class="margin-small-top text-small"><?php echo ($item["menu_name"]); ?></div>
            </a><?php endforeach; endif; else: echo "" ;endif; ?>
            <!--<a href="<?php echo ($item["menu_url"]); ?>" class="x3 margin-bottom">
                <div class="circle-bg text-white text-large <?php if($item["have_new"] == 1): ?>have_new<?php endif; ?>">
                    <span class="<?php echo ($item["menu_ico"]); ?>"></span>
                </div>
                <div class="margin-small-top text-small"><?php echo ($item["menu_name"]); ?></div>
            </a>-->
        </nav>
        <div class="clearfix text-center border-top border-bottom">
            <a href="tel:<?php echo ($project_info["project_tel"]); ?>" class="x6 padding border-right web-font">
                <span class="icon-wuye icon-phone text-large text-diy"></span>
                致电管理处
            </a>
            <a href="<?php echo ($project_info["project_config"]["novice"]); ?>" class="x6 padding">
                <span class="icon-wuye icon-hand-o-right text-large text-yellow"></span>
                新手指南
          </a>
        </div>
    </section>
    <footer class="fixed-bottom clearfix border-top bg padding-small text-center">
        <a href="<?php echo C('DOMAIN');?>" class="x3 text-diy text-small">
            <i class="icon iconfont text-diysize2">&#xe668;</i><br/>
            家园
        </a>
        <a href="<?php echo U('Prop/Neighbor/index');?>" class="x3 text-small">
            <i class="icon iconfont text-diysize2">&#xe60c;</i><br/>
            邻里
        </a>
        <a href="http://shop.guanyu.cn" class="x3 text-small">
            <i class="icon iconfont text-diysize2">&#xe68c;</i><br/>
            超市
        </a>
        <a href="<?php echo U('Prop/My/index');?>" class="x3 text-small">
            <i class="icon iconfont text-diysize2">&#xe616;</i><br/>
            我的
        </a>
    </footer>
</body>
</html>
<?php echo C("STATISTICAL_CODE");?>