
<div class="top">
    <div class="wrapper">
        <div class="logo">
            <div class="icon toplogo"></div>
        </div>
        <div class="openslider"><a href="#slider"><i class="fa fa-navicon"></i></a></div>
        <div class="topcon clearfix" id="slider">
            <ul class="nav" id="nav">
                <?php
                    $dir = $this->router->fetch_directory();
                    $uri = $this->uri->rsegment_array();
                    $last= $uri[count($uri)];
                ?>
                <a href="<?=base_url()?>"><li <?php if($dir == 'home/'){?>class="active" <?php }?> >首页</li></a>
                <a href="<?=base_url().'topic'?>"><li <?php if($dir == 'article/' && $last == 'topic'){?>class="active" <?php }?> >专题</li></a>
                <a href="<?=base_url().'production'?>"><li <?php if($dir == 'production/'){?>class="active" <?php }?> >艺术品</li></a>
                <a href="<?=base_url().'artist'?>"><li <?php if($dir == 'artist/'){?>class="active" <?php }?> >艺术家</li></a>
                <a href="<?=base_url().'article'?>"><li <?php if($dir == 'article/' && $last != 'topic'){?>class="active" <?php }?> >资讯</li></a>
            </ul>
            <div class="userarea">
                <?php
                    if($user['role']==0){
                ?>
                <div class="showsign" onclick="showsign()">
                    登陆
                    <font style="color:#FFF;font-weight: bold;margin:0 3px;">/</font>
                    注册
                </div>
                <?php
                    }else{
                ?>
                <div class="useropt">
                    <span class="user">Hi，<a href="" class="link"><?=$user["name"]?></a><div class="dot" style="display:none;"></div></span>
                    <span class="cart"><a href="" class="link"><i class="fa fa-shopping-cart" style="margin-right:3px;font-size: 16px;"></i>购物车</a><div class="numtooplit">0</div></span>
                </div>
                <?php
                    }
                ?>
                <div class="search">
                    <input type="text" placeholder="搜索艺术品、艺术家..." class="topsearch">
                    <i class="fa fa-search"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?=base_url()?>public/js/jquery.pageslide.min.js"></script>
<script>
    $(".openslider a").pageslide({direction: "left"});
</script>
