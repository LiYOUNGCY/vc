<body>
<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top;?>
    <!-- 主体 -->
    <div class="container">
        <div class="artist_detail">
            <div class="pic"><img src="<?=$artist['pic']?>"></div>
            <div class="detail">
                <div class="name"><?=$artist['name']?></div>
                <input type="hidden" value="<?=$artist['id']?>" id="aid">
                <div class="intro">
                    <p><?=$artist['intro']?></p>
                    <div class="more"><a href="" class="link">[阅读更多+]</a></div>
                </div>
            </div>
        </div>
        <div class="artistevaluate">
            <div class="title">维C推荐</div>
            <div class="detail">
                <p><?=$artist['evaluation']?></p>
            </div>
        </div>
        <div class="arts" id="arts">
            <!-- <div class="item">
                <figure class="effect-bubba">
                    <div class="art-image" style="background: url(<?=$artist['pic']?>);background-size:cover;background-position:50% 50%;"></div>
                    <figcaption>
                        <p>类型：123<br>尺寸：12 * 12cm</p>
                    </figcaption>           
                </figure>
                <div class="art-title">123</div>
                <ul class="art-info">
                    <li><i class="fa fa-heart-o"></i> 123</li>
                    <div class="price">123 RMB</div>
                </ul>
            </div> -->
        </div>
        <div class="loadmore" id="loadmore">加载更多</div>

    <?php echo $footer;?>
    </div>
</div>

<?php echo $sign;?>

</body>

<script>

$(function() {
    var page = 0;
    var aid = $("#aid").val();
    var arts = document.querySelector('#arts');
    loadarts();
    var masonry = new Masonry(arts, {
        itemSelector: '.item',
        columnWidth: 300,
        gutter: 30,
        isFitWidth: true,
        isAnimate: true
    });
    $("#loadmore").click(function(){
        if($(this).hasClass("disable")){
            return ;
        }
        if(!loadarts()){
            $(this).addClass("disable");
            return ;
        }
    })

    function loadarts(){
        $.ajax({
            type: 'POST',
            url: GET_ARTIST_ARTS,
            async: false,
            data: {
                page : page,
                aid : aid
            },
            dataType: 'json',
            success: function(data) {
                var arts = data;
                if(arts.error != null || arts.length === 0) {
                    console.log('Error');
                    return false;
                }
                page++;
                for (var i = 0; i < arts.length; i++){
                    var image   = arts[i].pic;
                    var type    = arts[i].type;
                    var like    = arts[i].like;
                    var price   = arts[i].price;
                    var name    = arts[i].name;
                    var width   = arts[i].w;
                    var height   = arts[i].h;
                    var elm = '<div class="item"><figure class="effect-bubba"><div class="art-image" style="background: url('+ image +');background-size:cover;background-position:50% 50%;"></div><figcaption><p>类型：'+ type +'<br>尺寸：'+ width +' * '+ height +'cm</p></figcaption></figure><div class="art-title">'+ name +'</div><ul class="art-info"><li><i class="fa fa-heart-o"></i> '+ like +'</li><div class="price">'+ price +' RMB</div></ul></div>'

                    $("#arts").append(elm);
                }
            }
        });
    }

});




</script>
</html>
