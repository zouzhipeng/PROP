<?php if (!defined('THINK_PATH')) exit();?>                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="60">id</th>
                                        <th width="100" class="Dropdown" field="idle_type" value="<?php echo ($idle_type); ?>">
                                            <a href="###"><span>
                                            <?php if($idle_type == 0): ?>出售信息
                                            <?php elseif($idle_type == 1): ?>
                                            求购信息
                                            <?php else: ?>
                                            闲置类型<?php endif; ?>
                                            </span><i class="fa fa-fw fa-caret-down"></i>
                                            <ul>
                                                <li value="">全部类型</li>
                                                <li value="0">出售信息</li>
                                                <li value="1">求购信息</li>
                                            </ul>
                                            </a>
                                        </th>
                                        <th>物品名</th>
                                        <th width="120">昵称</th>
                                        <th width="120">原价</th>
                                        <th width="120">现价</th>
                                        <th width="80" class="Dropdown" field="idle_state" value="<?php echo ($idle_state); ?>">
                                            <a href="###"><span>
                                            <?php if($idle_state == 0): ?>未审核
                                            <?php elseif($idle_state == 1): ?>
                                            已审核
                                            <?php elseif($idle_state == 2): ?>
                                            已完成
                                            <?php elseif($idle_state == 3): ?>
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
                                            </a>
                                        </th>
                                        <th width="120">添加时间</th>
                                        <th width="160">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                                        <td align="center"><?php echo ($item["idle_id"]); ?></td>
                                        <td><?php if($item["idle_type"] == 0): ?><span class="text-info">出售信息</span>
                                        <?php elseif($item["idle_type"] == 1): ?>
                                        <span class="text-warning">求购信息</span><?php endif; ?></td>
                                        <td><?php echo ($item["idle_name"]); ?></td>
                                        <td><span title="<?php echo ($uin_list['data'][$item['uin']]['phone']); ?>"><?php echo ($uin_list['data'][$item['uin']]['weixin_info']['nickname']); ?></span></td>
                                        <td>￥<?php echo ($item["idle_original_price"]); ?>元</td>
                                        <td>￥<?php echo ($item["idle_present_price"]); ?>元</td>
                                        <td><?php if($item["idle_state"] == 0): ?><button type="button" class="btn btn-sm btn-warning idle_verify" idle_id="<?php echo ($item["idle_id"]); ?>">审核</button>
                                        <?php elseif($item["idle_state"] == 1): ?>
                                        <span class="text-success">已审核</span>
                                        <?php elseif($item["idle_state"] == 2): ?>
                                        <span class="text-info">已完成</span>
                                        <?php elseif($item["idle_state"] == 3): ?>
                                        <span class="text-danger">已取消</span><?php endif; ?></td>
                                        <td><?php echo ($item["add_time"]); ?></td>
                                        <td><a class="btn btn-sm btn-primary idle_edit" href="###" idle_id="<?php echo ($item["idle_id"]); ?>"><i class="fa fa-edit fa-lg"></i> 编辑</a> <a class="btn btn-sm btn-danger idle_del" href="###" idle_id="<?php echo ($item["idle_id"]); ?>"><i class="fa fa-trash-o fa-lg"></i> 删除</a></td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>