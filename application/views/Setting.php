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
          <form id="setting" class="flp" action="<?=base_url().'account/setting/update_account' ?>" method='post'>
            <div class="form-group">
              <input class="flp-input" type="text" id="name" name="name">
              <label class="label" for="name">昵称</label>
            </div>
            <div class="form-group">
              <input class="flp-input" type="text" id="alias" name="alias">
              <label class="label" for="alias">主页地址(www.artvc.cc)</label>
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
            </div>
            <div class="form-group">
              <input class="flp-input" type="text" id="email" name="email">
              <label class="label" for="email">邮箱</label>
            </div>
            <div class="form-group">
              <input class="flp-input" type="text" id="area" name="area">
              <label class="label" for="area">地区</label>
            </div>
            <div class="form-group">
              <input class="flp-input" type="text" id="birthday" name="birthday">
              <label class="label" for="birthday">生日(YYYY-MM-DD)</label>
            </div>
            <div class="option">
              <div id="cancel" class="btn cancel">取消</div>
              <div id="save" class="btn save">保存</div>
            </div>
          </form>
        </main>
      </div>

    </div>
  </div>
</div>
</body>
<script type="text/javascript" src="<?=base_url()?>public/js/jquery.easing.min.js"></script>
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
    
  $.ajax({
    url:BASE_URL+"account/setting/get_msg",
    type:'post',
    dataType:'text',
    success:function(data) {
      var user = eval("(" + data + ")");

      var height = $("#name").outerHeight()/2 *-1 + "px";

      // if(user.name != '') {
      //   $("#name").val(user.name);
      //   $("#name").next().addClass("focussed").children().stop(true).each(function(i){
      //       $(this).css('top', height);
      //   })
      // }

      set_height('name', user.name, height);
      set_height('alias', user.alias, height);
      set_height('area', user.area, height);
      set_height('email', user.email, height);
      set_height('phone', user.phone, height);
      set_height('birthday', user.birthday, height);
      
      // $("#alias").val(user.alias);
      // $("#area").val(user.area);
      // $("#email").val(user.email);
      // $("#phone").val(user.phone);

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

  $('#save').click(function(){
    $('form').submit();
  });
});
</script>
</html>