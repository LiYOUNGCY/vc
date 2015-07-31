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
          <li class="active">
            <a href="<?=base_url().'setting';?>" class="link">基本信息</a>
          </li>
          <li>
            <a href="<?=base_url().'setting/pwd'?>" class="link">修改密码</a>
          </li> 
        </ul>
      </div>

      <div class="conversation">
        <main>
          <form id="setting" class="flp" action="<?=base_url().'account/setting/update_account' ?>" method='post'>
            <div class="form-group">
              <input class="flp-input" type="text" id="name" name="name">
              <label class="label" for="name">昵称</label>
              <div id="name_error" class="error_div"></div>
            </div>
            <div class="form-group">
              <input class="flp-input" type="text" id="alias" name="alias">
              <label class="label" for="alias">主页地址(www.artvc.cc/home)</label>
              <div id="alias_error" class="error_div"></div>
            </div>
            <div class="radio-box">
              <p>性别</p>
              <input class="radiocheck" name="sex" id="male" type="radio" value="1">
              <label class="nofull default left" for="male">男</label>
              <input class="radiocheck" name="sex" id="female" type="radio" value="2">
              <label class="nofull default left" for="female">女</label>
              <input class="radiocheck" name="sex" id="secret" type="radio" value="0">
              <label class="nofull default left" for="secret">保密</label>
            </div>
            <div class="form-group">
              <input class="flp-input" type="text" id="phone" name="phone">
              <label class="label" for="phone">手机</label>
              <div id="phone_error" class="error_div"></div>
            </div>
            <div class="form-group">
              <input class="flp-input" type="text" id="email" name="email">
              <label class="label" for="email">邮箱</label>
              <div id="email_error" class="error_div"></div>
            </div>
            <div class="form-group">
              <input class="flp-input" type="text" id="area" name="area">
              <label class="label" for="area">地区</label>
              <div id="area_error" class="error_div"></div>
            </div>
            <div class="form-group">
              <input class="flp-input" type="text" id="birthday" name="birthday">
              <label class="label" for="birthday">生日(YYYY-MM-DD)</label>
              <div id="birthday_error" class="error_div"></div>
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

  $(function(){
    var last_len = 0;
    var BASE_URL = $("#BASE_URL").val();
    var alias_check = true;
    $('#birthday').bind('input propertychange', function() {
      var str = $(this).val();
      var len = str.length;

      if(len == 4 && len == last_len + 1) {
        $(this).val(str+'-');
      }
      else if(len == 7 && len == last_len + 1) {
        $(this).val(str + '-');
      }
      last_len = len;

      if(len >= 10) {
        $(this).val(str.substr(0, 10));
      }
    });

    function set_height(input_id, data, height) {
      if(data != '') {
        $("#" + input_id).val(data);
        $("#" + input_id).next().addClass("focussed").children().stop(true).each(function(i){
            $(this).css('top', height);
        })
      }
    }
    
    function check_alias(alias)
    {
      $.ajax({
          url:BASE_URL+"account/setting/check_alias",
          type:'post',
          data:{
            alias:alias
          },
          success:function(data) {
             data = eval('('+data+')');
             if(data.error != null)
             {
                alias_check = false;
                $('#alias_error').html(data.error).css('display','block');
             }
             else if(data.success == 0)
             {
                alias_check = true;
             }  
          }   
        });
    }

  $.ajax({
    url:BASE_URL+"account/setting/get_msg",
    type:'post',
    dataType:'text',
    success:function(data) {
      var user = eval("(" + data + ")");

      var height = $("#name").outerHeight()/2 *-1 + "px";

      user.alias = user.alias.split('/');
      user.alias = user.alias[1];
      set_height('name', user.name, height);
      set_height('alias', user.alias, height);
      set_height('area', user.area, height);
      set_height('email', user.email, height);
      set_height('phone', user.phone, height);
      set_height('birthday', user.birthday, height);
      

      if(user.sex == 0) {
        $('#secret').attr('checked', 'true');
      }
      else if( user.sex == 1) {
        $('#male').attr('checked', 'true');
      }
      else if( user.sex == 2) {
        $('#female').attr('checked', 'true');
      }
    }
  });

  //验证各个字段是否合法
  $('#name').blur(function(){
    validate('name', $('#name').val());
  });
  $('#alias').blur(function(){
    var result = validate('alias', $('#alias').val());
    if(result)
    {
      check_alias($("#alias").val());
    }
  });
  $('#area').blur(function(){
    validate('area', $('#area').val());
  });
  $('#phone').blur(function(){
    validate('phone', $('#phone').val());
  });
  $('#email').blur(function(){
    validate('email', $('#email').val());
  });
  $('#birthday').blur(function(){
    validate('birthday', $('#birthday').val());
  });

  $('#save').click(function(){
    var name = validate('name', $('#name').val());
    var alias = validate('alias', $('#alias').val());
    var area = validate('area', $('#area').val());
    var phone = validate('phone', $('#phone').val());
    var email = validate('email', $('#email').val());
    var birthday = validate('birthday', $('#birthday').val());
    if( name && alias && area && phone && email && birthday && alias_check) {
      $('form').submit();
    }
  });
});
</script>
</html>