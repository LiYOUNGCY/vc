<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top;?>
    <!-- 主体 -->
    <div class="container">
    <div class="cart">
        <div class="title">购物车</div>
        <ul class="artlist" id="artlist">
            <!-- <li class="art clearfix">
                <div class="delete"><i class="fa fa-close"></i></div>
                <div class="pic" style="background: url(<?=base_url()?>public/img/topic/thumb2_1.jpg);background-size:cover;background-position:50% 50%;"></div>
                <div class="info">
                    <div class="name">几何</div>
                    <div class="artist">&nbsp;&nbsp;作者：<a href="" class="link">Bamford</a></div>
                    <div class="detail">
                        <div class="status-1">作品已售出，请移除商品再进行结算</div>
                        <div>油画，布面，100 X 30cm，2015年</div>
                        <div>装裱选择：金边（￥100）</div>
                        <div>售价：￥1000</div>
                    </div>
                </div>
                <div class="price">
                    ￥<font style="font-size:32px;color:#f7cc1e">3000</font>
                </div>
            </li> -->
        </ul>
        <div id="showder">
            <div class="final">
                <div class="font">
                    将有<font style="font-size:25px;color:#f7cc1e;margin:0 5px;" id="artnum"></font>件优秀的艺术品成为您的收藏
                </div>
                <div class="total">￥<font style="font-size:32px;" id="totalprice"></font></div>
            </div>
            <div class="topay">
              <div class="btn">去结算</div>
            </div>
        </div>
    </div>
    </div>
    <?php echo $footer;?>
</div>
</body>
<script>


$(function(){
    'use strict';
    var page = 0;

    loadgoods();

    $(".delete").click(function(){
        var id =  $(this).parent().attr("id");
        var goodprice = $(this).parent().find("#goodprice").html();
        goodprice = parseInt(goodprice);

        deletegood(id);
        pushcartcount();


        $(this).parent().fadeOut(400,function(){
            $(this).remove();
            if(!changefinal(goodprice)){
                nogoods();
            }
        })
    })

    function loadgoods(){
        $.ajax({
            type: 'POST',
            url: GET_CART_GOODS,
            async: false,
            dataType: 'json',
            success: function(data) {
                console.log(data);
                var good = data;
                console.log(good.length);
                if(good.error != null || good.length == 0) {
                    nogoods();
                    return false;
                }

                var sum   = 0;
                var count = good.length;
                for(var i = 0; i < good.length; i++){
                    var status      = good[i].status;
                    var status_elm  = '';
                    if(status == 1){
                        status_elm = '<div class="status-1">作品已售出，请移除商品再进行结算</div>';
                    }else if(status == 2){
                        status_elm = '<div class="status-1">作品已下架，请移除商品再进行结算</div>';                        
                    }
                    var id          = good[i].production_id;
                    var pid         = good[i].production_id;
                    var image       = good[i].pic;
                    var name        = good[i].name;
                    var artist      = good[i].artist_name;
                    var aid         = good[i].artist_id;
                    var medium      = good[i].medium;
                    var price       = good[i].price;
                    var sum_price   = good[i].sum_price;
                    var w           = good[i].w;
                    var h           = good[i].h;
                    var style       = good[i].style;
                    var time        = good[i].creat_time;
                    var frame_name  = good[i].frame_name;
                    var frame_price  = good[i].frame_price;


                    var elm = '' +
                    '<li class="art clearfix" id="'+ id +'">' +
                    '<div class="delete"><i class="fa fa-close"></i></div>' +
                    '<a href="<?=base_url()?>production/'+ pid +'">' +
                    '<div class="pic" style="background: url('+ image +');background-size:cover;background-position:50% 50%;"></div>' +
                    '</a>'+
                    '<div class="info">'+
                    '<div class="name"><a href="<?=base_url()?>production/'+ id +'" class="link">'+ name +'</a></div>' +
                    '<div class="artist">&nbsp;&nbsp;作者：<a href="<?=base_url()?>artist/'+ aid +'" class="link">'+ artist +'</a></div>' +
                    '<div class="detail">' +
                    status_elm +
                    '<div>'+ medium +'，'+ style +'，'+ w +' X '+ h +'cm，'+ time +'</div>' +
                    '<div>装裱选择：'+ frame_name +'（￥'+ frame_price +'）</div>' +
                    '<div>售价：￥'+ price +'</div>' +
                    '</div>' +
                    '</div>'+
                    '<div class="price">'+
                    '￥<font style="font-size:32px;color:#f7cc1e" id="goodprice">'+ sum_price +'</font>'+
                    '</div>' +
                    '</li>';


                    sum = sum + parseInt(sum_price);

                    $("#artlist").append(elm);
                }
                $("#artnum").html(count);
                $("#totalprice").html(sum);
            }
        });
    }
    function nogoods(){
        var elem = '' +
        '<div class="nonebox">' +
        '<div class="box">' +
        '<div class="text">您购物车还没有商品呢</div>' +
        '<div class="go">快去选购吧！</div>' +
        '<div class="opt">' +
        '<div class="btn"><a href="<?=base_url()?>topic">专题推荐</a></div>' +
        '<div class="btn"><a href="<?=base_url()?>production">精选作品</a></div>' +
        '</div></div></div>';

        $("#showder").html(elem);
    }
    function deletegood(id){
        console.log(id);
        $.ajax({
            type: 'POST',
            url: REMOVE_CART_GOODS,
            async: true,
            data: {
                id : id
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                var good = data;
                if(good.error != null || good.length === 0) {
                    console.log('Error');
                    return false;
                }

            }
        });
    }

    function changefinal(goodprice){
        var artnum = $("#artnum").html() - 1;
        if(artnum == 0){
            return false;
        }
        var total = $("#totalprice").html();
        total = parseInt(total);
        var finalprice = total - goodprice;
        $("#totalprice").html(finalprice);
        $("#artnum").html(artnum);
        return true;
    }

})

</script>
</html>
