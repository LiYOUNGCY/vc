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
                            <li>尺寸：<?php echo $production['w']." x ".$production['h'];?>cm</li>
                            <li>创作时间：<?=$production['creat_time']?></li>
                            <li>上市时间：<?=$production['publish_time']?></li>
                        </ul>
                    </div>
                    <div class="frame">
                        <div class="title">选裱推荐：</div>
                        <ul>
                            <li>
                                <div class="noframe">
                                    不装裱
                                </div>
                                <div class="frame_name">
                                    无
                                </div>
                                <div class="frame_price">
                                    ￥ <span>0</span>
                                </div>
                            </li>
                            <li>
                                <div class="frameimg">
                                    <img src="<?= base_url()?>public/img/jb.jpg" alt="金边">
                                </div>
                                <div class="frame_name">
                                    金边
                                </div>
                                <div class="frame_price">
                                    ￥ <span>200</span>
                                </div>
                            </li>
                            <li>
                                <div class="frameimg">
                                    <img src="<?= base_url()?>public/img/yb.jpg" alt="银边">
                                </div>
                                <div class="frame_name">
                                    银边
                                </div>
                                <div class="frame_price">
                                    ￥ <span>110</span>
                                </div>
                            </li>
                            <li>
                                <div class="frameimg">
                                    <img src="<?= base_url()?>public/img/jb.jpg" alt="金边">
                                </div>
                                <div class="frame_name">
                                    金边
                                </div>
                                <div class="frame_price">
                                    ￥ <span>200</span>
                                </div>
                            </li>
                        </ul>
                        <div class="frame_detail" id="fd1">
                            <img src="<?= base_url()?>public/img/jbx.jpg" alt="">
                        </div>
                        <div class="frame_detail" id="fd2">
                            <img src="<?= base_url()?>public/img/jbx.jpg" alt="">
                        </div>
                        <div class="frame_detail" id="fd3">
                            <img src="<?= base_url()?>public/img/jbx.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="price"><font style="font-weight:normal;color:#888888;font-size:16px;">售价：</font><?=$production['price']?> RMB</div>
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
    
    $(".frame li").each(function(i){
        $(this).hover(function(){
            var id = "#fd" + i;
            $(id).addClass("hover");
        },function(){
            var id = "#fd" + i;
            $(id).removeClass("hover");
        })
    });

    $(".addcart").click(function(){
        $.ajax({
            type: 'POST',
            url: ADD_CART_GOODS,
            async: false,
            data: {
                pid: pid
            },
            dataType: 'json',
            success: function (data) {
                var status = data;
                if (status.success == 0) {
                    swal("已添加到购物车!", "您可以在购物车里统一付款", "success");
                    pushcartcount();
                }
                else if (status.error != null) {
                    sweetAlert("添加购物车失败", status.error, "error");
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
