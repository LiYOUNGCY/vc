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
        <form id="setting" action="<?=base_url().'account/setting/update_account' ?>
          " method='post'>
          <div class="form-group">
            <label for="name">昵称：</label>
            <input id="name" name="name" type="text" autofocus>
            <div id="username_error" class="error_div"></div>
          </div>
          <div class="form-group">
            <label for="alias">主页：</label>
            www.artvc.cc/
            <input id="alias" name="alias" type="text" style="width:190px;">
            <div id="alias_error" class="error_div"></div>
          </div>
          <div class="form-group">
            <label>性别：</label>
            <div class="radio-group" id="sex">
              <div>
                <input type="radio" name="sex" value="1">男</div>
              <div>
                <input type="radio" name="sex" value="2">女</div>
              <div>
                <input type="radio" name="sex" value="0">保密</div>
            </div>
          </div>
          <div class="form-group">
            <label for="">生日：</label>
            <div class="birthday">
              <select id="year" name="year">
                <?php 
                  $year = (int)date("Y");
                  for($i = 0; $i <= 100; $i++) {
                    ?>
                <option value="<?=$year-$i?>
                  ">
                  <?=$year-$i?></option>
                <?php
                  }?></select>
              年
              <select id="mouth" name="mouth" onChange="return CheckDay();">
                <?php for($i = 1; $i <= 12; $i++) {
                      if($i < 10) { ?>
                <option value="<?=$i?>
                  ">
                  <?=$i?></option>
                <?php 
                      } else {
                        ?>
                <option value="<?=$i?>
                  ">
                  <?=$i?></option>
                <?php
                      }
                  }?></select>
              月
              <select id="day" name="day"></select>
              日
            </div>
          </div>
          <div class="form-group">
            <label for="">地区：</label>
            <input id="area" name="area" type="text">
            <div id="area_error" class="error_div"></div>
          </div>
          <div class="form-group">
            <label for="">邮箱：</label>
            <input id="email" name="email" type="text">
            <div id="email_error" class="error_div"></div>
          </div>
          <div class="form-group">
            <label for="">手机：</label>
            <input id="phone" name="phone" type="text">
            <div id="phone_error" class="error_div"></div>
          </div>
          <div class="width-100p">
            <div class="btn set-btn"> <font id="text">取消</font>
            </div>
            <div class="btn set-btn" onclick="Submit()"> <font id="text">保存</font>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
<script src="<?=base_url().'public/js/validate.js'?>"></script>
<script>
function Submit()
{
  document.getElementById("setting").submit();
}
function CheckDay() {
  $("#day").empty();
  var year  = $("#year").val();
  var mouth = $("#mouth").val();

  var day = getDayNum(year, mouth);
  for(var i = 1; i <= day; i++) {
    var option = $("<option>").val(i).text(i);
    $("#day").append(option);
  }
  
}
function getDayNum(Year,Month)
{
    var d = new Date(Year,Month,0);
    return d.getDate();
}
$(function (){
  var BASE_URL = $("#BASE_URL").val();
  $.ajax({
    url:BASE_URL+"account/setting/get_msg",
    type:'post',
    dataType:'text',
    success:function(data) {
      var user = eval("(" + data + ")");
      $("#name").val(user.name);
      $("#alias").val(user.alias);
      $("#area").val(user.area);
      $("#email").val(user.email);
      $("#phone").val(user.phone);

      var year = parseInt(user.birthday.substr(0, 4));
      var mouth= parseInt(user.birthday.substr(5, 2));
      var day  = parseInt(user.birthday.substr(6, 2));

      $("#year").find("option[value="+year+"]").attr("selected",true); 
      $("#mouth").find("option[value="+mouth+"]").attr("selected",true); 
      var MouthDay = getDayNum(year, mouth);
      for(var i = 1; i <= MouthDay; i++) {
        var option = $("<option>").val(i).text(i);
        $("#day").append(option);
      }
      $("#day").find("option[value="+day+"]").attr("selected",true); 

      $("#sex").find("input").each(function(){
        if($(this).attr("value") == user.sex) {
          $(this).attr('checked', true);
        }
      });
    }
  });

  //事件
  $('#name').blur(function (){
    var r = validate('username', $('#name').val());
  });
});
</script>
</html>