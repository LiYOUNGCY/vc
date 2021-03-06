<body>
<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="artist_detail">
            <div class="pic"><img src="<?= $artist['pic'] ?>"></div>
            <div class="detail">
                <div class="name"><?=$artist['name']?></div>
                <input type="hidden" value="<?=$artist['id']?>" id="aid">
                <div class="intro">
                    <p><?= $artist['intro'] ?></p>
                </div>
            </div>
        </div>
        <div class="artistevaluate">
            <div class="title">维C推荐</div>
            <div class="detail">
                <p><?= $artist['evaluation'] ?></p>
            </div>
        </div>
        <div class="item-list" id="arts">

           <!-- <div class="production">
               <img class="image" src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/production/thumb1_1440593600_1.jpg">
               <p class="title">天梯</p>
               <p class="author">作者：条野太郎</p>
               <div class="info">
                   <span class="type">油画</span>，
                   <span class="size">120cm X 90cm</span>
               </div>
               <div class="bottom clearfix">
                <div class="price" title="价格">4100 RMB</div>
                <div class="vote" title="收藏">158<div class="icon like"></div></div>
               </div>
           </div> -->

        </div>
        <div class="loadmore" id="loadmore">加载更多</div>
    </div>
    <?php echo $footer; ?>
</div>
</body>

<script>


$(function() {
    var page = 0;
    var aid = $("#aid").val();
    var arts = document.querySelector('#arts');

    var masonry = new Masonry(arts, {
        itemSelector: '.production',
        columnWidth: 300,
        gutter: 30,
        isFitWidth: true,
        isAnimate: true
    });

    loadarts();
    $("#loadmore").click(function(){
        if($(this).hasClass("disable")){
            return ;
        }
        if(!loadarts()){
            $(this).addClass("disable");
            return ;
        }
    })

    function loadarts(){
        $.ajax({
            type: 'POST',
            url: GET_ARTIST_ARTS,
            async: false,
            data: {
                page : page,
                aid : aid
            },
            dataType: 'json',
            success: function(data) {
                var arts = data;
                if(arts.error != null || arts.length === 0) {
                    console.log('Error');
                    return false;
                }
                page++;
                for (var i = 0; i < arts.length; i++){
                    var id      = arts[i].id;
                    var image   = arts[i].pic;
                    var style   = arts[i].style;
                    var like    = arts[i].like;
                    var price   = arts[i].price;
                    var name    = arts[i].name;
                    var w       = arts[i].w;
                    var h       = arts[i].h;
                    var width   = arts[i].width;
                    var height  = arts[i].height;



                    var $box =$(
                    '<div class="production">' +
                    '<a href="<?=base_url()?>production/'+ id +'">' +
                    '<div class="outsidebox"></div>' +
                    '<img class="image" src="'+ image +'" style="width: '+width+'px;height: '+height+'px;">' +
                    '<p class="title">'+ name +'</p>' +
                    '<div class="info">' +
                    '<span class="type">'+ style +'</span>，' +
                    '<span class="size">'+ w +'cm X '+ h +'cm</span>' +
                    '</div>' +
                    '<div class="bottom clearfix">' +
                    '<div class="price" title="价格">'+ price +' RMB</div>' +
                    '<div class="vote" title="收藏">'+ like +'<div class="icon like"></div></div>' +
                    '</div></a></div>');

                    $('.item-list').append($box);
                    masonry.appended($box)

                }
            }
        });
    }
});

</script>
</html>
