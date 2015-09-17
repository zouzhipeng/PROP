<?php if (!defined('THINK_PATH')) exit();?><div class="dialog-box bg-white" id="confirm_pay">
    <div class="list-item">
        <div class="padding border-bottom clearfix">
            <div class="x6 text-gray">付费信息</div>
            <div class="x6 text-right">物业费</div>
        </div>
        <div class="padding border-bottom clearfix">
            <div class="x6 text-gray">物业名称</div>
            <div class="x6 text-right"><?php echo ($project["project_name"]); ?></div>
        </div>
        <div class="padding border-bottom clearfix">
            <div class="x6 text-gray">物业电话</div>
            <div class="x6 text-right"><?php echo ($project["project_tel"]); ?></div>
        </div>
        <div class="padding border-bottom clearfix">
            <div class="x6 text-gray">钱包余额</div>
            <div class="x6 text-right">￥<?php echo ($money); ?>元</div>
        </div>
        <div class="padding border-bottom clearfix">
            <div class="x6 text-gray">需付款</div>
            <div class="x6 text-right">￥<?php echo ($total); ?>元</div>
        </div>
        <?php if($total > $money): ?><div class="padding border-bottom clearfix">
            <div class="x6 text-gray">需充值</div>
            <div class="x6 text-right">￥<?php echo ($total-$money); ?>元</div>
        </div>
        <div class="padding border-bottom clearfix">
            <div class="x6 text-gray">充值方式</div>
            <div class="x6 text-right">微信钱包</div>
        </div><?php endif; ?>
    </div>
    <div class="padding clearfix">
    	<input type="hidden" name="bill_id" value="<?php echo ($bill_id); ?>"/>
        <button name="to_pay" class="button x12 bg-yellow">确认付款</button>
    </div>
</div>
<script>
$("#confirm_pay button[name='to_pay']").click(function(e) {
    to_pay($("#confirm_pay input[name='bill_id']").val());
});
</script>