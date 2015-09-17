<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="paytitle">确认订单</div>
        <div class="paybox clearfix">
            <div class="infoma">
                <div>
                    <label>应收金额：</label><span class="price">￥ 3000</span>
                </div>
                <div class="item">
                    <label for="name">收货人</label>
                    <input type="text" name="name" id="name">
                </div>
                <div class="item">
                    <label for="tel">联系电话</label>
                    <input type="text" name="tel" id="tel">
                </div>
                <div class="item">
                    <label for="address">地址</label>
                    <div class="defaddress">广东省 佛山市 禅城区 小魔仙巴拉巴拉路520号1314房 <a href="javascript:void(0)" class="link"> [修改地址]</a></div>
                    <!-- <textarea name="address" id="address" cols="30" rows="10"></textarea> -->
                </div>
                <label></label>
                <div class="btn saveasdef">
                    保存为默认收货信息
                </div>
            </div>
            <div class="paymethor">
                <label>支付方式</label>
                <div class="methor">
                    <img src="<?=base_url()?>public/img/pay_Ali.jpg">
                    <div class="icon tick"></div>
                </div>
            </div>
            <div class="bottom">
                <div class="btn pay">去支付</div>
                <div class="serverule">
                    <input type="checkbox" name="rule" id="rule">我同意 <a href="javascript:void(0)" class="link">服务条款</a>
                </div>
            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
<?php
  if($user['role']==0){
    echo $sign;
  }
?>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>

    $(function () {

    })

</script>
</html>
