<body>
<?=$sidebar ?>
<div id="vi_container" class="container">
  <div id="shade"></div>
  <div id="sbtn" class="sbtn">
    <div class="icon">
      <div class="sidebtn"></div>
    </div>
  </div>
  <div class="content article-detial">
    <div class="author">
      <div class="head">
          <img src="<?=base_url().'public/img/mm1.jpg'?>">
      </div>
      <a href="<?=$article['author']['alias']?>"><span class="name"><?=$article['author']['name']?></span></a>
      <p class="author-info">不是一般的帅！</p>
    </div>
    <h1 class="article-title"><?=$article['title']?></h1>
    <h2 class="article-subtitle"><?=$article['subtitle']?></h2>
    <p class="article-info"> 字数1137 阅读904 评论6 喜欢13 </p>
    <div class="clearfix"></div>
    <div class="article-content">
      <?=$article['content']?> 
    </div>
  
    <hr class="line">
    
    <div class="playground">
      <div class="box buddycloud">
        <div class="stream">
          <article class="topic">
          <?php
          $len = count($comment) < 5 ? count($comment) : 5;
          for($i = 0; $i < $len; $i++) {
          ?>
            <section class="opener">
              <div class="avatar"><img src="<?=$comment[$i]['user']['pic']?>"></div>
              <div class="postmeta">
                <span class="time"><?=$comment[$i]['publish_time']?></span>
              </div>
              <span class="name"><?=$comment[$i]['user']['name']?></span>
              <p><?=$comment[$i]['content']?></p>
            </section>
            <?php } ?>
            <div class="hidden">
            <?php $len = count($comment);
            for($i = 5; $i < $len; $i ++) {
            ?>
              <section class="opener">
                <div class="avatar"><img src="<?=$comment[$i]['user']['pic']?>"></div>
                <div class="postmeta">
                  <span class="time"><?=$comment[$i]['publish_time']?></span>
                </div>
                <span class="name"><?=$comment[$i]['user']['name']?></span>
                <p><?=$comment[$i]['content']?></p>
              </section>
            <?php } ?>
            </div>
            <!-- /hidden -->
            <section class="seeMore">
              <span>查看全部评论</span>
            </section>
          </article>
          <article class="topic">
            <div class="answer clearfix" style="position:relative;">
                <div id="submit" class="send btn">发送</div>
                <div id="emotion" class="emotion"></div>
                <div class="msg"><textarea id="msg"  placeholder="想说写什么..."></textarea></div>
            </div>
          </article>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="http://127.0.0.1/artvc/public/js/paperfold/paperfold.js"></script>
<script>
  $(function (){
    var BASE_URL = $('#BASE_URL').val();
    var COMMENT_URL = BASE_URL + 'article/detail/write_comment';
    alert(COMMENT_URL);

    //获取文章的id
    var aid = window.location.href.split("/");
    aid = aid[aid.length-1];


    $('#msg').flexText();
    $('#emotion').qqFace({ 
        assign: 'msg',                          //给输入框赋值 
        path: BASE_URL + "public/img/face/"     //表情图片存放的路径 
    });

    $('#submit').click(function(){
      var str = $('#msg').val();
      alert(str);
      $.ajax({
          type: "POST",
          url: COMMENT_URL,
          data: {
              aid: aid,
              comment: str
          },
          success: function(data) {
              alert(data);
              var obj = eval("(" + data + ")");
          }
      });

    });
  });
</script>
</body>
</html>