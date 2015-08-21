<body>
<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top;?>
    <!-- 主体 -->
    <div class="container">
        <div class="art wrapper">
            <div class="artarea">
                <div class="title"><?=$production['name']?></div>
                
                <div class="artpic" id="picture-frame">
                    <img src="<?=$production['pic_thumb']?>" class="thumb" data-src="<?=$production['pic']?>"/>    
                </div>
                <div class="artinfo">
                    <div class="likebtn">
                        <div class="support"></div>
                        <div class="num">12</div>
                    </div>
                    <div class="info"><?=$production['type']?>，<?=$production['marterial']?>，<?php echo $production['w']." x ".$production['h'];?>cm，<?=$production['creat_time']?></div>
                </div>
            </div>
            <div class="artistarea">
                <div class="artistinfo clearfix">
                    <div class="artist">
                        <div class="head">
                            <img src="<?=$production['artist']['pic']?>">
                        </div>
                        <div class="name"><a href="" class="link"><?=$production['artist']['name']?></a></div>
                    </div>
                    <div class="atristintro">
                        <p><?=$production['artist']['intro']?></p>
                        <div class="btn">更多介绍</div>
                    </div>
                </div>
                <div class="artintro">
                    <div class="title">作品介绍</div>
                    <div class="intro">
                        <p><?=$production['intro']?></p>
                    </div>
                    <div class="price"><font style="font-weight:normal;color:#888888;font-size:16px;">售价：</font><?=$production['price']?> RMB</div>
                </div>
                <div class="useropt">
                    <div class="btn buy">立即购买</div>
                    <div class="btn addcart">加入购物车</div>
                </div>
            </div>
        </div>

    
    <?php echo $footer;?>
    </div> 
</div>

<?php echo $sign;?>

</body>

<script>
$(function() {
    $("#picture-frame").zoomToo({
        magnify: 1
    });
    
});
</script>
</html>
