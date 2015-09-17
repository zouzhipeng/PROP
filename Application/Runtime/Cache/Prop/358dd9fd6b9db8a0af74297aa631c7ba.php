<?php if (!defined('THINK_PATH')) exit();?>            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="padding clearfix border-bottom">
                <a href="<?php echo U('idle_info',array('idle_id'=>$item['idle_id']));?>" class="li-item x12" idle_id="<?php echo ($item["idle_id"]); ?>">
                    <div class="img">
                    	<?php if(!empty($item["idle_img"]["0"])): ?><img src="<?php echo ($item["idle_img"]["0"]); ?>?imageView2/0/w/100/h/75" alt="" class="" width="100" /><?php endif; ?>
                    </div>
                    <div class="intro padding-left">
                        <h4 class="margin-top"><?php echo ($item["idle_name"]); ?></h4>
                        <div class="margin-top text-gray">￥<?php echo ($item["idle_present_price"]); ?></div>
                    </div>
                    <div class="img text-gray datetime">
                        <?php echo ($item["add_time"]); ?>
                    </div>
                </a>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>