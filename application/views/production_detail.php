<body>
<input id="pid" type="hidden" name="pid" value="<?= $production['id']?>">
<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top;?>
    <!-- 主体 -->
    <div class="container">
        <div class="art wrapper">
            <div class="artarea">
                <div class="title"><?=$production['name']?></div>

                <div class="artpic" id="picture-frame">
                    <img src="<?=$production['pic']?>" class="thumb" data-src="<?=$production['pic']?>"/>
                </div>
                <div class="like">
                    <div class="likebtn" id="vote">
                        <div class="support"></div>
                        <div class="num" id="seeLike"><?=$production['like']?></div>
                    </div>
                </div>
            </div>
            <div class="artistarea">
                <div class="artistinfo clearfix">
                    <div class="artist">
                        <div class="head">
                            <a href="<?=base_url()?>artist/<?=$production['artist']['id']?>" class="link">
                            <img src="<?=$production['artist']['pic']?>">
                            </a>
                        </div>
                        <div class="name"><a href="<?=base_url()?>artist/<?=$production['artist']['id']?>" class="link"><?=$production['artist']['name']?></a></div>
                    </div>
                    <div class="atristintro">
                        <p><?=$production['artist']['intro']?></p>
                    </div>
                </div>
                <div class="artinfo">
                    <div class="info">
                        <ul>
                            <li>艺术门类：<?=$production['medium']?></li>
                            <li>风格：<?=$production['style']?></li>
                            <li>尺寸：<?php echo $production['w'].' x '.$production['h'];?>cm</li>
                            <li>创作时间：<?=$production['creat_time']?></li>
                            <li>上市时间：<?=$production['publish_time']?></li>
                        </ul>
                    </div>
                    <div class="frame">
                        <div class="title">选裱推荐：</div>
                        <ul>
                            <div class="icon tick" id="tick"></div>
                            <?php $i=0; foreach($frame as $value) { ?>
                                <li data-id="<?=$value['id']?>" <?php if($i == 0) echo 'class="fc"';?>>
                                    <div class="frameimg">
                                        <img src="<?=$value['image']?>" alt="<?=$value['name']?>">
                                    </div>
                                    <div class="frame_name">
                                        <?=$value['name']?>
                                    </div>
                                    <div class="frame_price">
                                        ￥ <span id="fp"><?=$value['price']?></span>
                                    </div>
                                </li> 
                            <?php $i++;} ?>
                        </ul>
                        <?php foreach ($frame as $value) {
    if (isset($value['thumb'])) {
        ?>
                        <div class="frame_detail" id="fd<?=$value['id']?>">
                            <img src="<?=$value['thumb']?>" alt="">
                        </div>
                        <?php 
    }
} ?>
                    </div>
                </div>
                <div class="price"><span style="font-weight:normal;color:#888888;font-size:16px;">售价：</span><?=$production['price']?> <font class="price_fp"></font> RMB</div>
                <div class="useropt">
                    <div class="btn addcart">加入购物车</div>
                    <div class="btn buy">立即购买</div>
                </div>
                <div class="csopt">
                    <div class="phonecs">
                        联系客服：<span class="pcs">4008-123-456</span>
                    </div>or
                    <div class="onlinecs">
                        <a href="<?=base_url()?>msg/csmsg" class="link">在线客服</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="artintro">
            <div class="title">作品介绍</div>
            <div class="intro">
                <p><?=$production['intro']?></p>
            </div>

        </div>
    </div>
    <input type="hidden" id="pid" value="<?=$production['id']?>">
    <?php echo $footer;?>
</div>
</body>

<script>
$(function() {
    $("#picture-frame").zoomToo({
        magnify: 2
    });
    var pid = $('#pid').val();
    var fid = 1;

    $(".frame li").each(function(){
        var i = $(this).attr('data-id');
        $(this).hover(function(){
            var id = "#fd" + i;
            $(id).addClass("hover");
        },function(){
            var id = "#fd" + i;
            $(id).removeClass("hover");
        })
    });

    $(".frame li").each(function(i){
        $(this).click(function(){
            var loca = 60 + i*88 + "px";
            $("#tick").css({left:loca});
            fid = $(this).attr('data-id');
            var fp = $(this).find("#fp").html();
            if(fp == 0){
                $(".price_fp").html("");
            }else{
                $(".price_fp").html("+ "+fp);
            }

        })
    });


    $(".addcart").click(function(){
        console.log(pid);
        console.log(fid);
        $.ajax({
            type: 'POST',
            url: ADD_CART_GOODS,
            async: false,
            data: {
                production_id: pid,
                frame_id: fid
            },
            dataType: 'json',
            success: function (data) {
                var status = data;
                console.log(data);
                if (status.success == 0) {
                    swal("已添加到购物车!", "您可以在购物车里统一付款", "success");
                    pushcartcount();
                }
                else if (status.error != null) {
                    sweetAlert(status.message, status.error, "error");
                    return false;
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
    //点赞
    var pid = $('#pid').val();
    $("#vote").click(function () {
        $.ajax({
            type: 'POST',
            url: VOTE_PRODUCTION,
            data: {
                pid: pid
            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var status = data;
                if (status.success == 0) {
                    if ($('#vote').hasClass('focus')) {
                        $('#vote').attr('class', 'likebtn blur');
                        $('#seeLike').html(parseInt($('#seeLike').html()) - 1);
                    }
                    else {
                        $('#vote').attr('class', 'likebtn focus');
                        $('#seeLike').html(parseInt($('#seeLike').html()) + 1);
                    }
                }
                else if (status.error != null) {
                   swal({
                        title: "请登录后再进行操作",
                        text: data.error,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "注册/登录",
                        cancelButtonText: "取消",
                        closeOnConfirm: false
                    },
                    function () {
                        window.location.href = LOGIN_URL;
                    });
                    return false;
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
    // END vote click event

});
</script>
</html>
