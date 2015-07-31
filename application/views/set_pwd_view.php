<body>
<?=$sidebar?>
<div id="vi_container" class="container">
  <div id="shade"></div>
  <div id="sbtn" class="sbtn">
    <div class="icon sidebtn">
    </div>
  </div>
  <div class="content">
    <div class="container-head">
      <h1>设置中心</h1>
      <div id="vi_menu" class="vi-menu width-100p">
        <ul>
          <li>
            <a href="<?=base_url().'setting';?>" class="link">基本信息</a>
          </li>
          <li class="active">
            <a href="<?=base_url().'setting/pwd'?>" class="link">修改密码</a>
          </li> 
        </ul>
      </div>

      <div class="conversation">
        <main>
          <form id="setting" class="flp" action="<?=base_url().'account/setting/change_password' ?>" method='post'>
            <div class="form-group">
              <input class="flp-input" type="password" id="old_pwd" name="old_pwd">
              <label class="label" for="old_pwd">旧密码</label>
            </div>
            <div class="form-group">
              <input class="flp-input" type="password" id="pwd" name="pwd">
              <label class="label" for="pwd">新密码</label>
              <div id="pwd_error" class="error_div"></div>              
            </div>
            <div class="form-group">
              <input class="flp-input" type="password" id="confirm_pwd" name="confirm_pwd">
              <label class="label" for="confirm_pwd">确认密码</label>
              <div id="confirm_error" class="error_div"></div>              
            </div>
            <div class="option">
              <div id="cancel" class="btn cancel">取消</div>
              <div id="save" class="btn save">保存</div>
            </div>
          </form>
        </main>
      </div>
      
    </div>
    <?=$footer?>
  </div>
</div>
</body>
<script type="text/javascript" src="<?=base_url()?>public/js/jquery.easing.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>public/js/validate.js"></script>
<script type="text/javascript">
  $(".label").each(function(){
    var sop = '<span class="ch">'; //span opening
    var scl = '</span>'; //span closing
    //split the label into single letters and inject span tags around them
    $(this).html(sop + $(this).html().split("").join(scl+sop) + scl);
    //to prevent space-only spans from collapsing
    $(".ch:contains(' ')").html("&nbsp;");
  })

  var d;
  //animation time
  $(".flp-input").focus(function(){
    //calculate movement for .ch = half of flp-input height
    var tm = $(this).outerHeight()/2 *-1 + "px";
    //label = next sibling of flp-input
    //to prevent multiple animation trigger by mistake we will use .stop() before animating any character and clear any animation queued by .delay()
    $(this).next().addClass("focussed").children().stop(true).each(function(i){
      d = i*50;//delay
      $(this).delay(d).animate({top: tm}, 200, 'easeOutBack');
    })
  })
  $(".flp-input").blur(function(){
    //animate the label down if content of the input is empty
    if($(this).val() == "")
    {
      $(this).next().removeClass("focussed").children().stop(true).each(function(i){
        d = i*50;
        $(this).delay(d).animate({top: 0}, 500, 'easeInOutBack');
      })
    }
  })

  $(function (){

    $("#pwd").blur(function(){
      validate('pwd',$(this).val());
    });
         
    $('#save').click(function (){
      var pwd = $('#pwd').val();
      var confirm_pwd = $('#confirm_pwd').val();
      if( pwd === confirm_pwd ) {
        $("#confirm_error").css('display','none');        
        $('form').submit();
      }else
      {
          $("#confirm_error").html(VALIDATE_ERROR["format_confirm_pwd"]);
          $("#confirm_error").css('display','block');
      }
    });
  });

</script>
</html>