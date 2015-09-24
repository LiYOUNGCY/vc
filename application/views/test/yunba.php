<html>
<head>
  <input type="">
  <script type="text/javascript" src="<?=base_url()?>public/js/jquery.js"></script>  
  <script type="text/javascript" src="<?=base_url()?>public/js/yunba/socket.io-1.3.5.min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>public/js/yunba/yunba-js-sdk.js"></script>
</head>
<body>
  <input type="button" value="订阅" onclick="subscribe();" />
  <input type="button" value="发送" onclick="send();" />
<script>
$(function(){


  var yunba = new Yunba({
    server: 'sock.yunba.io', port: 3000, appkey: '55bc441c14ec0a7d21a70c5a'});
  yunba.init(function (success) {
    if (success) {
      yunba.connect_by_customid('12345', function (success, msg) {
        if (success)
          {

              yunba.subscribe({'topic': '12345'}, function (success, msg) {
              if (success)
                console.log('你已成功订阅频道');
              else
                console.log(msg);
              });  

              
              yunba.set_message_cb (function (data) {
                  alert('来自频道：' + data.topic + '&nbsp;&nbsp;&nbsp;消息内容：' + data.msg);
              });          
          }
        else
          console.log(msg);
      });
    }
  });  
});

</script>
</body>
</html>