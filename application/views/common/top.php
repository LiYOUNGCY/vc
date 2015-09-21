
<div class="top">
    <div class="openslider"><a href="#slider"><i class="fa fa-navicon"></i></a></div>
    <div class="wrapper clearfix" id="slider">
        <div class="topleft">
            <div class="logo">
                <a href="<?=base_url()?>"><div class="icon toplogo"></div></a>
            </div>
            <ul class="nav" id="nav">
                <?php
                    $dir = $this->router->fetch_directory();
                    $uri = $this->uri->rsegment_array();
                    $last= $uri[count($uri)];
                ?>
                <a href="<?=base_url().'topic'?>"><li <?php if($dir == 'article/' && $last == 'topic'){?>class="active" <?php }?> >专题</li></a>
                <a href="<?=base_url().'production'?>"><li <?php if($dir == 'production/'){?>class="active" <?php }?> >艺术品</li></a>
                <a href="<?=base_url().'artist'?>"><li <?php if($dir == 'artist/'){?>class="active" <?php }?> >艺术家</li></a>
                <a href="<?=base_url().'article'?>"><li <?php if($dir == 'article/' && $last != 'topic'){?>class="active" <?php }?> >资讯</li></a>
            </ul>
        </div>
        <div class="topright">
            <div class="userarea clearfix">
                <?php if($user['role']==0){ ?>
                <div class="showsign">
                    <a href="javascript:$.pageslide.close()" onclick="showsign(1)">登陆</a>
                    <font style="color:#F8E901;font-weight: bold;margin:0 3px;">/</font>
                    <a href="javascript:$.pageslide.close()" onclick="showsign(2)">注册</a>
                </div>
                <?php }else{ ?>
                <div class="useropt">
                    <a href="<?=base_url()?>cart" class="link" title="购物车"><span class="cart"><i class="fa fa-shopping-cart" style="font-size: 16px;"></i> （ <font color="#f7cc1e" id="cartcount"></font> ）</span></a>
                    <span class="user">Hi，<a href="<?=base_url()?>like" class="link"><?=$user["name"]?></a><div class="dot" style="display:block;"></div></span>
                    <a href="<?=base_url()?>account/main/logout" class="link"><span class="logout">退出</span></a>
                </div>
                <?php } ?>
                <div class="search" id="search">
                    <input type="text" placeholder="搜索艺术品、艺术家..." class="s_ipt" id="s_ipt">
                    <i class="fa fa-search" id="s_sipt"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?=base_url()?>public/js/jquery.pageslide.min.js"></script>
<script>
    

    $(function(){
        $(".openslider a").pageslide({direction: "left"});

        if($(window).width() > 960){
            $("#s_sipt").bind("click",function(){
                if($("#search").hasClass('active')){
                    $("#search").css({"width" : "26px"});
                    $("#search").removeClass('active');
                    $(".s_ipt").css({"display":"none"});
                    return ;
                }
                $("#search").css({"width": "185px"});
                $("#search").addClass('active');
                $(".s_ipt").css({"display":"block"});
                $(".s_ipt").focus();
            });
        }
        
        
        $.ajax({
            type: 'POST',
            url: GET_CART_GOODS,
            async: true,
            data: {
                page : 0
            },
            dataType: 'json',
            success: function(data) {
                var good = data;
                if(good.error != null || good.length === 0) {
                    console.log('Error');
                    return false;
                }
                var count =  good.count;
                $("#cartcount").html(count);
            }
        });    

        
    })
</script>
