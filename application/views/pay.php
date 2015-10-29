<body>

<div class="main-wrapper">
    <!-- 修改地址 -->
    <div class="editaddress" style="display:none;">
        <div class="box">
            <label for="address">收货地址</label>
            <div style="margin:10px 0;">
                <select class="select" name="province" id="s1">
                    <option></option>
                </select>
                <select class="select" name="city"< id="s2">
                    <option></option>
                </select>
                <select class="select" name="town" id="s3">
                    <option></option>
                </select>
                <input id="address" name="address" type="hidden" value=""/>
            </div>
            <input type="text" value="" name="address" placeholder="详细地址" id="address">
            <div class="error_div" id="address_error"></div>
            <label for="contact">收件人</label>
            <input type="text" value="" name="contact" id="contact" placeholder="例如：张三">
            <div class="error_div" id="contact_error"></div>
            <label for="phone">联系电话</label>
            <input type="text" value="" name="phone" id="phone">
            <div class="error_div" id="phone_error"></div>
            <div class="opt">
                <div class="btn cancel">取消</div>
                <div class="btn save">保存</div>    
            </div>
            
        </div>
    </div>
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->

    <div class="container">
        <div class="payment">
            <div class="pmh">确认收货信息</div>
            <div class="addressbox">
            <?php if(! empty($address)) {?>
            
                <div class="info">
                    <span class="address">
                        寄送到： <?=$address['address']?> （<?=$address['contact']?> 收）
                    </span>
                    <span class="tel">
                        <?=$address['phone']?>
                    </span>    
                </div>
                
                <div class="toeditaddress">
                    <a href="javascript:void(0);" class="link changeadress">修改地址</a>
                </div>

                <!-- 暂无收货地址，请 <a class="link changeadress" href="javascript:void(0);">添加收货地址</a> -->

                <?php } else { ?>
                暂无收货地址，请 <a class="link" href="">添加收货地址</a>
                <?php } ?>

            </div>
            <div class="pmh">确认配送方式</div>
            <div class="peisong">
                <ul>
                    <li>
                        自提
                        <div class="intro" style="display:none">
                            <span id="price">0</span> RMB （自提地址：广州市天河区某某某某地方）
                        </div>
                    </li>
                    <li>
                        送货上门
                        <div class="intro" style="display:none">
                            <span id="price">0</span> RMB （广州地区免费送货上门）
                        </div>
                    </li>
                    <li>
                        中铁物流
                        <div class="intro" style="display:none">
                            <span id="price">100</span> RMB （专业中铁艺术物流）
                        </div>
                    </li>
                    <li class="nomargin">
                        顺丰快递
                        <div class="intro" style="display:none">
                            <span id="price">50</span> RMB （顺丰速递）
                        </div>
                    </li>
                </ul>
                <div class="tips"></div>
            </div>
            <div class="pmh">清单</div>
            <div class="goodslist">

                <?php foreach($goods as $key => $value) { ?>
                <div class="item">
                    <a href="javascript:void(0)">
                        <div class="pic" style="background: url(<?= $value['pic']?>);background-size:cover;background-position:50% 50%;"></div>
                    </a>
                    <div class="info">
                        <div class="name">（ <a href="" class="link"><?=$value['name']?></a> ）</div>
                        <div class="detail">
                            <div>装裱选择：<?=$value['frame_name']?>（￥<?=$value['frame_price']?>）</div>
                            <div>售价：￥<?=$value['price']?></div>
                            <div>总价：<span class="price"><?=$value['sum_price']?></span></div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="pmh">支付方式</div>
            <div class="paymethor">
                <div class="item">
                    <div class="icon tick"></div>
                    <img src="<?=base_url()?>public/img/pay_Ali.jpg" alt="支付宝">
                    <div class="poundage">手续费：1.2%</div>
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
                    <span class="partprice f_sumgoods_price">10200</span> RMB
                </div>
                <div class="part">
                    <label for="">运费：</label>
                    <span class="partprice f_peisong_price">0</span> RMB
                </div>
                <div class="part">
                    <label for="">手续费：</label>
                    <span class="partprice f_poundage_price">100</span> RMB
                </div>
                <div class="sum">
                    <div class="text">应付总额：<span class="sum_price">10300</span> RMB</div>
                    <div class="btn submitorder" id="submit">提交订单</div>
                </div>
            </div>
        </div>
    </div>
    <form action="<?=base_url()?>pay/main/pay_for_cart" method="post" target="_blank">
        <input type="hidden" name="contact_id" value="1">
        <input type="hidden" name="transport_id" value="1">
        <input type="hidden" name="issue_header" value="">
        <input type="hidden" name="uj" value="" id="uj">
    </form>
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
                    var peisong_price = $(".peisong .tips").find("#price").html();
                    $(".f_peisong_price").html(peisong_price);
                    calsumprice();
                }
            })
        });
        $('input:radio[name="invoice"]').change(function(){
            var val = $(this).val();
            if(val == 1){
                $(".invoice_title").css({"display":"block"});
            }else{
                $(".invoice_title").css({"display":"none"});
            }
        })
        $(".changeadress").click(function(){
            $(".editaddress").css({"display":"block"});
        })
        $(".editaddress .cancel").click(function(){
            $(".editaddress").css({"display":"none"});  
        })
        

        function calsumprice(){
            var goods_price = parseInt($(".f_sumgoods_price").html());
            var peisong_price = parseInt($(".f_peisong_price").html());
            var poundage_price = parseInt($(".f_poundage_price").html());
            var sum_price = goods_price + peisong_price + poundage_price;
            $(".sum_price").html(sum_price);
        }

        //提交订单
        $('#submit').click(function(){
            console.log('submit');
            $.ajax({
                url: BASE_URL + 'pay/main/validate_pay',
                type: 'post',
                data: {
                    transport_id: 1
                },
                dataType: 'json',
                async:false,
                success: function (data) {
                    console.log(data);
                },
                error: function (data) {
    //                    sweetAlert('Network connect fail');
                    console.log(data);
                }
            });

            $('#uj').val('qsc');
            $('form').submit();
        });

    })

</script>
</html>
  