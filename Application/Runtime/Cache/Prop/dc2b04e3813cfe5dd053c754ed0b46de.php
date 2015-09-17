<?php if (!defined('THINK_PATH')) exit();?>			<?php if(is_array($bill_list)): $i = 0; $__LIST__ = $bill_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="padding border-bottom clearfix pay_list">
                <div class="x6 clearfix">
                    <div class="float-left">
                        <input type="hidden" name="bill_price" value="<?php echo ($item["bill_price"]); ?>"/>
                    </div>
                    <div style="margin-left:18px;">
                        <div><?php echo ($item["bill_title"]); ?></div>
                        <div class="text-gray text-small margin-top"><?php echo ($item["bill_time"]); ?></div>
                    </div>
                </div>
                <div class="x3 text-yellow">￥<?php echo ($item["bill_price"]); ?></div>
                <div class="x3 text-right">
                	<?php if($item["status"] == 1 ): ?><span style="padding: 2px 20px; color:#2c7;" bill_id="<?php echo ($item["bill_id"]); ?>">已支付</span>
                    <?php else: ?>
                    <span style="padding: 2px 20px; color:#F00;" bill_id="<?php echo ($item["bill_id"]); ?>">未支付</span><?php endif; ?>
                </div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>