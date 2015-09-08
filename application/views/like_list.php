
<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
       <div class="personal">
           <div class="userinfo clearfix">
               <div class="uhead">
                   <img src="<?=$user['pic']?>">
               </div>
               <div class="info">
                   <ul>
                       <li><label>昵称</label>：<?=$user['name']?></li>
                       <li><label>收货地址</label>：<?php echo 1 ? "空" : $user['address'];?></li>
                       <li><label>联系电话</label>：<?php echo 1 ? "空" : $user['tel'];?></li>
                       <li><label>联系人</label>：</li>
                   </ul>

                    <a href="<?=base_url()?>setting"><div class="editinfo btn">修改信息</div></a>
               </div>
           </div>
           <div class="ptitle">
             个人中心
           </div>
           <div class="pmenu">
               <ul>
                   <li class="active">
                     <a href="javascript:void(0);"><div class="icon plike"></div></a>
                   </li>
                   <li>
                     <a href="javascript:void(0);"><div class="icon pbuyed"></div></a>
                   </li>
                   <li>
                     <a href="javascript:void(0);"><div class="icon pmsg"></div></a>
                   </li>
                   <li>
                     <a href="javascript:void(0);"><div class="icon psetting"></div></a>
                   </li>
               </ul>
           </div>
       </div>
    </div>
    <?php echo $footer; ?>
</div>
<?php echo $sign; ?>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>


</script>
</html>
