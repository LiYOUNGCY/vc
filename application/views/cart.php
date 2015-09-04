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
                <div class="pic" style="background: url(http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/slider/1440004716_1.jpg);background-size:cover;background-position:50% 50%;"></div>
                <div class="info">
                    <div class="name">受打击难受的</div>
                    <div class="artist">&nbsp;&nbsp;作者：<a href="" class="link">鸡巴白</a></div>
                    <div class="detail">油画，布面，20 X 30cm，2015年，</div>
                </div>
                <div class="price">
                    ￥<font style="font-size:32px;color:#f7cc1e">5000</font>
                </div>
            </li> -->
        </ul>
        <div class="final">
            <div class="font">
                将有<font style="font-size:25px;color:#f7cc1e;margin:0 5px;" id="artnum"></font>件优秀的艺术品成为您的收藏
            </div>
            <div class="total">￥<font style="font-size:32px;">5000</font></div>
        </div>
        <div class="topay">
          <div class="btn">确认购买</div>  
        </div>
        
    </div>
    <?php echo $footer;?>
    </div> 
</div>
<?php echo $sign;?>   
</body>
<script>


$(function(){
    var page = 0;
    $(".delete").click(function(){
        $(this).parent().fadeOut(400,function(){
            $(this).remove();
        })
    })
    loadgoods();

    function loadgoods(){
        $.ajax({
            type: 'POST',
            url: GET_CART_GOODS,
            async: false,
            data: {
                page : page
            },
            dataType: 'json',
            success: function(data) {
                var good = data;
                if(good.error != null || good.length === 0) {
                    console.log('Error');
                    return false;
                }

                page++;
                var count =  good.count;
                var good  = good.goods;
                for(var i = 0; i < good.length; i++){
                    var id          = good[i].production.id;
                    var image       = good[i].production.pic;
                    var name        = good[i].production.name;
                    var artist      = good[i].artist.name;
                    var artistid    = good[i].artist.ids;
                    var type        = good[i].production.type;
                    var price       = good[i].production.price;
                    var w           = good[i].production.w;
                    var h           = good[i].production.h;
                    var marterial   = good[i].production.marterial;
                    var time        = good[i].production.creat_time;

                    var elm = '<li class="art clearfix"><div class="delete"><i class="fa fa-close"></i></div><a href="<?=base_url()?>production/'+ id +'"><div class="pic" style="background: url('+ image +');background-size:cover;background-position:50% 50%;"></div></a><div class="info"><div class="name">'+ name +'</div><div class="artist">&nbsp;&nbsp;作者：<a href="<?=base_url()?>artist/'+ artistid +'" class="link">'+ artist +'</a></div><div class="detail">'+ type +'，'+ marterial +'，'+ w +' X '+ h +'cm，'+ time +'</div></div><div class="price">￥<font style="font-size:32px;color:#f7cc1e">'+ price +'</font></div></li>';

                    $("#artlist").append(elm);
                }
                $("#artnum").html(count);
            }
        });    
    }   

})

</script>
</html>
