<?php if (!defined('THINK_PATH')) exit();?>                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="60">id</th>
                                        <th width="120" class="Dropdown" field="server_class" value="<?php echo ($server_class); ?>">
                                            <a href="###"><span>
                                            <?php if($status == 1): ?>投诉建议
                                            <?php elseif($status == 2): ?>
                                            维修报障
                                            <?php elseif($status == 3): ?>
                                            施工申请
                                            <?php else: ?>
                                            分类<?php endif; ?>
                                            </span><i class="fa fa-fw fa-caret-down"></i>
                                            <ul>
                                                <li value="">全部</li>
                                                <li value="1">投诉建议</li>
                                                <li value="2">维修报障</li>
                                                <li value="3">施工申请</li>
                                            </ul>
                                            </a>
                                        </th>
                                        <th>标题</th>
                                        <th width="120">业主</th>
                                        <th width="120">电话</th>
                                        <th width="100" class="Dropdown" field="server_state" value="<?php echo ($server_state); ?>">
                                            <a href="###"><span>
                                            <?php if($server_state == 0): ?>未审核
                                            <?php elseif($server_state == 1): ?>
                                            已联系
                                            <?php elseif($server_state == 2): ?>
                                            已分派
                                            <?php elseif($server_state == 3): ?>
                                            已完成
                                            <?php else: ?>
                                            服务状态<?php endif; ?>
                                            </span><i class="fa fa-fw fa-caret-down"></i>
                                            <ul>
                                                <li value="">全部</li>
                                                <li value="0">未审核</li>
                                                <li value="1">已联系</li>
                                                <li value="2">已分派</li>
                                                <li value="3">已完成</li>
                                            </ul>
                                            </a>
                                        </th>
                                        <th width="120">添加时间</th>
                                        <th width="160">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                                        <td align="center"><?php echo ($item["server_id"]); ?></td>
                                        <td><?php echo ($item["server_class_name"]); ?></td>
                                        <td><?php echo ($item["server_title"]); ?></td>
                                        <td><?php echo ($uin_list['data'][$item['uin']]['weixin_info']['nickname']); ?></td>
                                        <td><?php echo ($uin_list['data'][$item['uin']]['phone']); ?></td>
                                        <td id="server_state_<?php echo ($item["server_id"]); ?>">
                                        <?php if($item["server_state"] == 0): ?><i class="fa fa-times fa-lg text-danger"></i>未审核
                                        <?php elseif($item["server_state"] == 1): ?>
                                            <i class="fa fa-phone fa-lg text-warning"></i>已联系
                                        <?php elseif($item["server_state"] == 2): ?>
                                            <i class="fa fa-user fa-lg text-info"></i>已分派
                                        <?php elseif($item["server_state"] == 3): ?>
                                            <i class="fa fa-check fa-lg text-success"></i>已完成<?php endif; ?>
                                        </td>
                                        <td><?php echo ($item["add_time"]); ?></td>
                                        <td>
                                        <?php if($item["status"] == 0): ?><a class="btn btn-sm btn-primary serv_view" href="###" server_id="<?php echo ($item["server_id"]); ?>"><i class="fa fa-eye fa-lg"></i> 查看</a> 
                                        <!--<a class="btn btn-sm btn-danger bill_del" href="###" server_id="<?php echo ($item["server_id"]); ?>"><i class="fa fa-trash-o fa-lg"></i> 删除</a>--><?php endif; ?>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>