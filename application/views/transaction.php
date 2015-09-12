<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="personal">
            <div class="userinfo clearfix">
                <div class="uhead">
                    <img src="<?= $user['pic'] ?>">
                </div>
                <div class="info">
                    <ul>
                        <li><label>昵称</label>：<?= $user['name'] ?></li>
                        <li><label>收货地址</label>：<?php echo 1 ? "空" : $user['address']; ?></li>
                        <li><label>联系电话</label>：<?php echo 1 ? "空" : $user['tel']; ?></li>
                        <li><label>联系人</label>：</li>
                    </ul>
                    <a href="<?= base_url() ?>setting">
                        <div class="editinfo btn">修改信息</div>
                    </a>
                </div>
            </div>
            <div class="ptitle">
                个人中心
            </div>
            <div class="pmenu">
                <ul>
                    <li>
                        <a href="<?= base_url() ?>like">
                            <div class="icon plike"></div>
                            <div class="mt">我的喜欢</div>
                        </a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0);">
                            <div class="icon pbuyed"></div>
                            <div class="mt">购买记录</div>
                        </a>
                    </li>
                    <li class="tc">
                        <a href="<?= base_url() ?>cart">
                            <div class="icon pcart"></div>
                            <div class="mt">购物车</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>msg">
                            <div class="icon pmsg"></div>
                            <div class="mt">信息</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>setting/safe">
                            <div class="icon psetting"></div>
                            <div class="mt">安全设置</div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="transaction">
                <div class="list">

                </div>
            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
<?php
if ($user['role'] == 0) {
    echo $sign;
}
?>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>
$(function(){
    var page = 0;

    function loadmore(){
        $.ajax({
            type: 'POST',
            url: GET_PERSONAL_TRANSACTION,
            async: false,
            data: {
                page: page
            },
            dataType: 'json',
            success: function (data) {
                // var items = eval('(' + data + ')');
                var items = data;

                if (items.error != null || items.length === 0) {
                    console.log('Error');
                    return;
                }

                page++;



                for (var i = 0; i < items.length; i++) {
                    var time        = items[i].buy_time;
                    var goods       = items[i].production;
                    var total       = items[i].amount;
                    var status      = items[i].status; 
                    var logistics   = items[i].logistics;
                    var address     = items[i].address;
                    var lid         = items[i].lid;

                    time = time.substr(0, 10);

                    var box = '' +
                    '<div class="box clearfix">' + 
                    '<div class="time"><div class="icon pgoods"></div><p>'+ time +'</p></div>' +
                    '<div class="glist clearfix">';

                    for(var j = 0; j < goods.length; j++){
                        var id     = goods[j].id;
                        var name   = goods[j].name; 
                        var pic    = goods[j].pic;
                        box += '' +
                        '<div class="good">' +
                        '<div class="pic icon pgoodsbg"><a href="<?=base_url()?>production/'+ id +'" class="link"><div style="background: url('+ pic +');background-size:cover;background-position:50% 50%;"></div></a></div>' +
                        '<div class="name"><a href="<?=base_url()?>production/'+ id +'" class="link">《'+ name +'》</a></div>' + 
                        '</div>'
                    }

                    box += '' +
                    '<div class="total"> <p>￥ '+ total +'</p></div>';
                    if(status == 0){
                        box += '</div><div class="boxbottom"><div class="status icon psending">待发货</div></div></div>'
                    }else if(status == 1){
                        box += '' +
                        '<div class="logistics">' +
                        '<p>快递：'+ logistics +' '+ lid +'</p>' +
                        '<p>地址：'+ address +'</p>' +
                        '</div><div class="confirmgood btn">确认收货</div></div>' +
                        '<div class="boxbottom"><div class="status icon psended">已发货</div></div></div>'
                    }else if(status == 2){
                        box += '' +
                        '<div class="logistics">' +
                        '<p>快递：'+ logistics +' '+ lid +'</p>' +
                        '<p>地址：'+ address +'</p>' +
                        '</div></div>' +
                        '<div class="boxbottom"><div class="status icon pconform">确认收货</div></div></div>'
                    }

                    $(".transaction .list").append(box);

                }
            }
        });
    }


    loadmore();
})
</script>
</html>