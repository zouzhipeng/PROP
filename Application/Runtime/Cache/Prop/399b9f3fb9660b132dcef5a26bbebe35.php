<?php if (!defined('THINK_PATH')) exit();?>			<?php if(is_array($serv_list)): $i = 0; $__LIST__ = $serv_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="padding border-bottom clearfix pay_list">
                <div class="x9 clearfix">
                    <div class="float-left">
                        <?php echo ($item["server_id"]); ?>
                    </div>
                    <div class="text-left" style="margin-left:18px;">
                        <div><?php echo ($item["server_title"]); ?>
                        <?php if($item["server_state"] == 0): ?>(未审核)
                        <?php elseif($item["server_state"] == 1): ?>
                        	(已联系)
                        <?php elseif($item["server_state"] == 2): ?>
                        	(已分派)
                        <?php elseif($item["server_state"] == 3): ?>
                        	(已完成)<?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="x3 text-right float-right"><?php echo ($item["add_time"]); ?></div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>