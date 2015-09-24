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
                    <div class="likebtn" id="vote">
                        <div class="support"></div>
                        <div class="num" id="seeLike"><?=$production['like']?></div>
                    </div>
                    <div class="info"><?=$production['type']?>，<?=$production['marterial']?>，<?php echo $production['w']." x ".$production['h'];?>cm，<?=$production['creat_time']?></div>
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
    </div>
    <?php echo $footer;?>
</div>
</body>

<script>
$(function() {
    $("#picture-frame").zoomToo({
        magnify: 2
    });

    //点赞
    var aid = $('#aid').val();
    $("#vote").click(function () {
        $.ajax({
            type: 'POST',
            url: VOTE_PRODUCTION,
            async: false,
            data: {
                aid: aid
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
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "注册/登录",
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
