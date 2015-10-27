<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="payment">
            <div class="pmh">确认收货信息</div>
            <div class="addressbox">
                <div class="info">
                    <span class="address">
                        寄送到： 广东省 广州市 天河区 怡景花园4座5号 （灼神 收）
                    </span>
                    <span class="tel">
                        1860000000
                    </span>    
                </div>
                
                <div class="editaddress">
                    <a href="" class="link">修改地址</a>
                </div>
                <!-- 暂无收货地址，请 <a class="link" href="">添加收货地址</a> -->
            </div>
            <div class="pmh">确认配送方式</div>
            <div class="peisong">
                <ul>
                    <li class="focus">
                        自提
                        <div class="intro" style="display:none">
                            <span>0 RMB</span> （自提地址：广州市天河区某某某某地方）
                        </div>
                    </li>
                    <li>
                        送货上门
                        <div class="intro" style="display:none">
                            <span>0 RMB</span> （广州地区免费送货上门）
                        </div>
                    </li>
                    <li>
                        中铁物流
                        <div class="intro" style="display:none">
                            <span>100 RMB</span> （专业中铁艺术物流）
                        </div>
                    </li>
                    <li class="nomargin">
                        顺丰快递
                        <div class="intro" style="display:none">
                            <span>50 RMB</span> （顺丰速递）
                        </div>
                    </li>
                </ul>
                <div class="tips"><span>0 RMB</span> （自提地址：广州市天河区某某某某地方）</div>
            </div>
            <div class="pmh">清单</div>
            <div class="goodslist">
                <div class="item">
                    <a href="javascript:void(0)">
                        <div class="pic" style="background: url(<?=base_url()?>public/img/topic/thumb2_1.jpg);background-size:cover;background-position:50% 50%;"></div>
                    </a>
                    <div class="info">
                        <div class="name">（ <a href="" class="link">小狗</a> ）</div>
                        <div class="detail">
                            <div>装裱选择：金边（￥100）</div>
                            <div>售价：￥2000</div>
                            <div>总价：<span class="price">2100</span></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <a href="javascript:void(0)">
                        <div class="pic" style="background: url(<?=base_url()?>public/img/topic/thumb2_1.jpg);background-size:cover;background-position:50% 50%;"></div>
                    </a>
                    <div class="info">
                        <div class="name">（ <a href="" class="link">小狗</a> ）</div>
                        <div class="detail">
                            <div>装裱选择：金边（￥100）</div>
                            <div>售价：￥2000</div>
                            <div>总价：<span class="price">2100</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pmh">支付方式</div>
            <div class="paymethor">
                <div class="item">
                    <div class="icon tick"></div>
                    <img src="<?=base_url()?>public/img/pay_Ali.jpg" alt="支付宝">
                </div>
            </div>
            <div class="pmh">发票信息</div>
            <div class="invoice">
                <div class="opt">
                    <label><input name="invoice" id="invoice" type="radio" value="0" checked="" /> 不开发票 </label> 
                    <label><input name="invoice" id="invoice" type="radio" value="1" /> 开发票 </label>
                </div>
                <div class="invoice_title" style="display:none">
                    <label for="invoice_title">发票抬头：</label>
                    <input type="text" name="invoice_title" id="invoice_title" class="ipt">
                </div>
            </div>
            <hr />
            <div class="sumup">
                <div class="part">
                    <label for="">商品总额：</label>
                    <span class="partprice">10200 RMB</span>
                </div>
                <div class="part">
                    <label for="">运费：</label>
                    <span class="partprice">0 RMB</span>
                </div>
                <div class="part">
                    <label for="">手续费：</label>
                    <span class="partprice">100 RMB</span>
                </div>
                <div class="sum">
                    <div class="text">应付总额：<span class="sum_price">10300</span> RMB</div>
                    <div class="btn submitorder">提交订单</div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>

    $(function () {
        $(".peisong li").each(function(){
            $(this).click(function(){
                if($(this).hasClass('focus')){
                    return;
                }else{
                    $(".peisong li").removeClass('focus');
                    $(this).addClass('focus');
                    var tip = $(this).find(".intro").html();
                    $(".peisong .tips").html(tip);
                }            
            })
        })
        $('input:radio[name="invoice"]').change(function(){
            var val = $(this).val();
            if(val == 1){
                $(".invoice_title").css({"display":"block"});
            }else{
                $(".invoice_title").css({"display":"none"});
            }
        })
    })

</script>
</html>
  