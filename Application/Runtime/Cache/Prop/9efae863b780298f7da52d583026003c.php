<?php if (!defined('THINK_PATH')) exit();?>            <?php if(empty($list)): ?><ul>
                    <li>
                        <div class="margin-top text-center">
                            <div class="no-content">
                                <span class="icon-bullhorn text-white"></span>
                            </div>
                            <div class="margin-top">
                            	您还没有发布路线！
                            </div>
                        </div>
                    </li>
                </ul><?php endif; ?>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="padding clearfix border-bottom">
                <a href="<?php echo U('carpool_info',array('carpool_id'=>$item['carpool_id']));?>" class="li-item x12" carpool_id="<?php echo ($item["carpool_id"]); ?>">
                    <div class="img table-cell">
                        <?php if(!empty($item["carpool_img"])): ?><img src="<?php echo ($item["carpool_img"]); ?>?imageView2/0/w/100/h/75" alt="" class="" width="100" /><?php endif; ?>
                    </div>
                    <div class="text text-gray padding-left height-small margin-small-top table-cell">
                        <div>标题</div>
                        <div>路线</div>
                        <div>出发时间</div>
                    </div>
                    <div class="intro padding-left height-small margin-small-top table-cell">
                        <div><?php echo ($item["carpool_title"]); ?></div>
                        <div><?php echo ($item["carpool_start"]); if(!empty($item["carpool_start"])): ?>-<?php endif; echo ($item["carpool_route"]); if(!empty($item["carpool_end"])): ?>-<?php endif; echo ($item["carpool_end"]); ?></div>
                        <div><?php echo ($item["carpool_gotime"]); ?></div>
                    </div>
                </a>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>