<body>
<?=$sidebar?>
<div id="vi_container" class="container">
  <div id="shade"></div>
  <div id="sbtn" class="sbtn">
    <div class="icon">
      <div class="sidebtn"></div>
    </div>
  </div>
  <div class="content">
    <div class="container-head">
      <h1>设置中心</h1>
      <div id="vi_menu" class="vi-menu width-100p">
        <ul>
          <li class="active">
            <a href="<?=base_url().'notification';?>" class="link">基本信息</a>
          </li>
          <li>
            <a href="<?=base_url().'notification/conversation'?>" class="link">修改密码</a>
          </li>
          <li>
            <a href="#" class="link">评论</a>
          </li>
          <li>
            <a href="#" class="link">赞</a>
          </li>
        </ul>
      </div>
      <div class="conversation">
        <main>
          <form class="flp">
            <div>
              <input class="flp-input" type="text" id="name" name="name">
              <label for="name">昵称</label>
            </div>
            <div>
              <input class="flp-input" type="text" id="alias" name="alias">
              <label for="alias">主页地址(www.artvc.cc)</label>
            </div>
            <div>
              <input class="flp-input" type="text" id="phone" name="phone">
              <label for="phone">手机</label>
            </div>
            <div>
              <input class="flp-input" type="text" id="email" name="email">
              <label for="email">邮箱</label>
            </div>
            <div>
              <input class="flp-input" type="text" id="area" name="area">
              <label for="area">地区</label>
            </div>
          </form>
        </main>

      </div>
    </div>
  </div>
</div>
</body>
<script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>public/js/jquery.easing.min.js"></script>
<script type="text/javascript">
  $(".flp label").each(function(){
    var sop = '<span class="ch">'; //span opening
    var scl = '</span>'; //span closing
    //split the label into single letters and inject span tags around them
    $(this).html(sop + $(this).html().split("").join(scl+sop) + scl);
    //to prevent space-only spans from collapsing
    $(".ch:contains(' ')").html("&nbsp;");
  })

  var d;
  //animation time
  $(".flp input").focus(function(){
    //calculate movement for .ch = half of input height
    var tm = $(this).outerHeight()/2 *-1 + "px";
    //label = next sibling of input
    //to prevent multiple animation trigger by mistake we will use .stop() before animating any character and clear any animation queued by .delay()
    $(this).next().addClass("focussed").children().stop(true).each(function(i){
      d = i*50;//delay
      $(this).delay(d).animate({top: tm}, 200, 'easeOutBack');
    })
  })
  $(".flp input").blur(function(){
    //animate the label down if content of the input is empty
    if($(this).val() == "")
    {
      $(this).next().removeClass("focussed").children().stop(true).each(function(i){
        d = i*50;
        $(this).delay(d).animate({top: 0}, 500, 'easeInOutBack');
      })
    }
  })
</script>
</html>