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
                    <div class="detail">油画，布面，100 X 30cm，2015年，</div>
                </div>
                <div class="price">
                    ￥<font style="font-size:32px;color:#f7cc1e">3000</font>
                </div>
            </li> -->
        </ul>
        <div class="final">
            <div class="font">
                将有<font style="font-size:25px;color:#f7cc1e;margin:0 5px;" id="artnum"></font>件优秀的艺术品成为您的收藏
            </div>
            <div class="total">￥<font style="font-size:32px;" id="totalprice"></font></div>
        </div>
        <div class="topay">
          <div class="btn">确认购买</div>  
        </div>
        
    </div>
    </div>
    <?php echo $footer;?> 
</div>
</body>
<script>


$(function(){
    var page = 0;

    loadgoods();

    $(".delete").click(function(){
        var id =  $(this).parent().attr("id");
        deletegood(id);
        pushcartcount();
        $(this).parent().fadeOut(400,function(){
            $(this).remove();
        })
    })

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
                var sum   = 0;
                var count =  good.count;
                var good  = good.goods;
                for(var i = 0; i < good.length; i++){
                    var id          = good[i].id;
                    var pid         = good[i].production.id;
                    var image       = good[i].production.pic;
                    var name        = good[i].production.name;
                    var artist      = good[i].artist.name;
                    var aid         = good[i].artist.ids;
                    var type        = good[i].production.type;
                    var price       = good[i].production.price;
                    var w           = good[i].production.w;
                    var h           = good[i].production.h;
                    var marterial   = good[i].production.marterial;
                    var time        = good[i].production.creat_time;

                    var elm = '' +
                    '<li class="art clearfix" id="'+ id +'">' +
                    '<div class="delete"><i class="fa fa-close"></i></div>' +
                    '<a href="<?=base_url()?>production/'+ pid +'">' +
                    '<div class="pic" style="background: url('+ image +');background-size:cover;background-position:50% 50%;"></div>' +
                    '</a>'+ 
                    '<div class="info">'+ 
                    '<div class="name"><a href="<?=base_url()?>production/'+ id +'" class="link">'+ name +'</a></div>' +
                    '<div class="artist">&nbsp;&nbsp;作者：<a href="<?=base_url()?>artist/'+ aid +'" class="link">'+ artist +'</a></div>' +
                    '<div class="detail">'+ type +'，'+ marterial +'，'+ w +' X '+ h +'cm，'+ time +'</div>' +
                    '</div>'+ 
                    '<div class="price">'+ 
                    '￥<font style="font-size:32px;color:#f7cc1e">'+ price +'</font>'+ 
                    '</div>' +
                    '</li>';


                    sum = sum + parseInt(price);

                    $("#artlist").append(elm);
                }
                $("#artnum").html(count);
                $("#totalprice").html(sum);
            }
        });    
    }
    function deletegood(id){
        $.ajax({
            type: 'POST',
            url: REMOVE_CART_GOODS,
            async: true,
            data: {
                id : id
            },
            dataType: 'json',
            success: function(data) {
                var good = data;
                if(good.error != null || good.length === 0) {
                    console.log('Error');
                    return false;
                }

            }
        });  
    }

})

</script>
</html>
