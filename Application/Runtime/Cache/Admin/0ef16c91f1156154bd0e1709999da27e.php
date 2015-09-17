<?php if (!defined('THINK_PATH')) exit();?>                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="60">id</th>
                                        <th>标题</th>
                                        <th width="160">楼盘名</th>
                                        <th width="120" class="Dropdown" field="notice_state" value="<?php echo ($notice_state); ?>">
                                            <a href="###"><span>
                                            <?php if($notice_state == 0): ?>草稿箱
                                            <?php elseif($notice_state == 1): ?>
                                            已发布
                                            <?php else: ?>
                                            状态<?php endif; ?>
                                            </span><i class="fa fa-fw fa-caret-down"></i>
                                            <ul>
                                                <li value="">全部</li>
                                                <li value="0">草稿箱</li>
                                                <li value="1">已发布</li>
                                            </ul>
                                            </a>
                                        </th>
                                        <th width="120">添加时间</th>
                                        <th width="160">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                                        <td align="center"><?php echo ($item["notice_id"]); ?></td>
                                        <td><?php echo ($item["notice_title"]); ?> <?php if($item["is_top"] == 1): ?><i class="fa fa-arrow-up fa-lg text-success"></i><?php endif; ?></td>
                                        <td><?php echo ($item["project"]); ?></td>
                                        <td>
                                        <?php if($item["notice_state"] == 1): ?><i class="fa fa-check fa-lg text-success"></i>已发布
                                        <?php else: ?>
                                            <i class="fa fa-file-text-o fa-lg text-danger"></i>草稿 <button type="button" class="btn btn-xs btn-warning notice_verify" notice_id="<?php echo ($item["notice_id"]); ?>">发布</button><?php endif; ?>
                                        </td>
                                        <td><?php echo ($item["add_time"]); ?></td>
                                        <td><a class="btn btn-sm btn-primary notice_edit" href="###" notice_id="<?php echo ($item["notice_id"]); ?>"><i class="fa fa-edit fa-lg"></i> 编辑</a> <a class="btn btn-sm btn-danger notice_del" href="###" notice_id="<?php echo ($item["notice_id"]); ?>"><i class="fa fa-trash-o fa-lg"></i> 删除</a></td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>