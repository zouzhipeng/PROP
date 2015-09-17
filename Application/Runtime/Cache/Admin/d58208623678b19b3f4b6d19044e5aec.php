<?php if (!defined('THINK_PATH')) exit();?>                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="60">id</th>
                                        <th width="100" class="Dropdown" field="carpool_type" value="<?php echo ($carpool_type); ?>">
                                            <a href="###"><span>
                                            <?php if($carpool_type == 1): ?>我有车
                                            <?php elseif($carpool_type == 2): ?>
                                            我没车
                                            <?php else: ?>
                                            拼车类型<?php endif; ?>
                                            </span><i class="fa fa-fw fa-caret-down"></i>
                                            <ul>
                                                <li value="">全部类型</li>
                                                <li value="1">我有车</li>
                                                <li value="2">我没车</li>
                                            </ul>
                                            </a>
                                        </th>
                                        <th>标题</th>
                                        <th>路线</th>
                                        <th width="160">出发时间</th>
                                        <th width="120">业主</th>
                                        <th width="120" class="Dropdown" field="carpool_state" value="<?php echo ($carpool_state); ?>">
                                            <a href="###"><span>
                                            <?php if($carpool_state == 0): ?>未审核
                                            <?php elseif($carpool_state == 1): ?>
                                            已审核
                                            <?php elseif($carpool_state == 2): ?>
                                            已完成
                                            <?php elseif($carpool_state == 3): ?>
                                            已取消
                                            <?php else: ?>
                                            状态<?php endif; ?>
                                            </span><i class="fa fa-fw fa-caret-down"></i>
                                            <ul>
                                                <li value="">全部</li>
                                                <li value="0">未审核</li>
                                                <li value="1">已审核</li>
                                                <li value="2">已完成</li>
                                                <li value="3">已取消</li>
                                            </ul>
                                            </a></th>
                                        <th width="120">添加时间</th>
                                        <th width="160">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                                        <td align="center"><?php echo ($item["carpool_id"]); ?></td>
                                        <td><?php if($item["carpool_type"] == 1): ?><span class="text-info">我有车</span>
                                        <?php elseif($item["carpool_type"] == 2): ?>
                                        <span class="text-warning">我无车</span><?php endif; ?></td>
                                        <td><?php echo ($item["carpool_title"]); ?></td>
                                        <td><?php echo ($item["carpool_start"]); ?>-<?php echo ($item["carpool_route"]); ?>-<?php echo ($item["carpool_end"]); ?></td>
                                        <td><?php echo ($item["carpool_gotime"]); ?></td>
                                        <td><?php echo ($item["add_time"]); ?></td>
                                        <td><?php if($item["carpool_state"] == 0): ?><button type="button" class="btn btn-sm btn-warning carpool_verify" carpool_id="<?php echo ($item["carpool_id"]); ?>">审核</button>
                                        <?php elseif($item["carpool_state"] == 1): ?>
                                        <span class="text-success">已审核</span>
                                        <?php elseif($item["carpool_state"] == 2): ?>
                                        <span class="text-info">已完成</span>
                                        <?php elseif($item["carpool_state"] == 3): ?>
                                        <span class="text-danger">已取消</span><?php endif; ?></td>
                                        <td><?php echo ($item["add_time"]); ?></td>
                                        <td><a class="btn btn-sm btn-primary carpool_edit" href="###" carpool_id="<?php echo ($item["carpool_id"]); ?>"><i class="fa fa-edit fa-lg"></i> 编辑</a> <a class="btn btn-sm btn-danger carpool_del" href="###" carpool_id="<?php echo ($item["carpool_id"]); ?>"><i class="fa fa-trash-o fa-lg"></i> 删除</a></td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>