<?php if (!defined('THINK_PATH')) exit();?>                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="60">id</th>
                                        <th>标题</th>
                                        <th>账单地址</th>
                                        <th>账单金额</th>
                                        <th width="100" class="Dropdown" field="status" value="<?php echo ($status); ?>">
                                            <a href="###"><span>
                                            <?php if($status == 0): ?>未付款
                                            <?php elseif($status == 1): ?>
                                            已付款
                                            <?php else: ?>
                                            状态<?php endif; ?>
                                            </span><i class="fa fa-fw fa-caret-down"></i>
                                            <ul>
                                                <li value="">全部</li>
                                                <li value="0">未付款</li>
                                                <li value="1">已付款</li>
                                            </ul>
                                            </a>
                                        </th>
                                        <th width="120">支付时间</th>
                                        <th width="120">添加时间</th>
                                        <th width="160">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                                        <td align="center"><?php echo ($item["bill_id"]); ?></td>
                                        <td><?php echo ($item["bill_title"]); ?></td>
                                        <td><?php echo ($item["bill_address"]); ?></td>
                                        <td><?php echo ($item["bill_price"]); ?></td>
                                        <td>
                                        <?php if($item["status"] == 1): ?><i class="fa fa-check fa-lg text-success"></i>已付
                                        <?php else: ?>
                                            <i class="fa fa-times fa-lg text-danger"></i>未付<?php endif; ?>
                                        </td>
                                        <td><?php echo ($item["pay_time"]); ?></td>
                                        <td><?php echo ($item["add_time"]); ?></td>
                                        <td>
                                        <?php if($item["status"] == 0): ?><a class="btn btn-sm btn-primary bill_edit" href="###" bill_id="<?php echo ($item["bill_id"]); ?>"><i class="fa fa-edit fa-lg"></i> 编辑</a> 
                                        <a class="btn btn-sm btn-danger bill_del" href="###" bill_id="<?php echo ($item["bill_id"]); ?>"><i class="fa fa-trash-o fa-lg"></i> 删除</a><?php endif; ?>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>