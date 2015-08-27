<body>
<div class="main-wrapper">
    <?php echo $top;?>
    <div class="container">
        <div class="article-list" id="article-list">
<!--             <div class="menu" id="nav">
                <div class="btn select">全部</div>
                <div class="btn select">风格</div>
                <div class="btn select">目的</div>
                <div class="btn select">价格</div>
            </div> -->
            <!--
    <div class="container" id="vi_container">

        <div class="content">
            <div class="article-list" id="article-list">
                <div class="menu">
                    <div class="btn select">全部</div>
                    <div class="btn select">风格</div>
                    <div class="btn select">目的</div>
                    <div class="btn select">价格</div>

                </div>
                <!-- <div class="box">
                    <div class="ishadow">
                        <img class="image" src="<?=base_url()?>public/img/load.gif" data-src="img/1 (1).jpg" alt=""/>
                        <div class="shadow"><i class="fa fa-eye"></i></div>
                    </div>
                    <p class="title">标题：我的世界</p>
                    <p class="content">这是一段介绍因为爱爱爱爱爱爱爱爱啊啊这是
                        一段介绍因为爱爱爱爱爱爱爱爱啊啊这是一段介绍因为爱爱爱爱爱爱爱爱啊啊
                        这是一段介绍因为爱爱爱爱爱爱爱爱啊啊dasfdasfdasfdasfdasfda
                        sfdasfssfffffffffffffdsafdasfdasfdasfdasfdasfdasfdasf
                    </p>
                    <div class="bottom clearfix">
                        <div class="like">
                            <i class="fa fa-heart"></i>
                            <span>199</span>
                        </div>
                        <div class="read">
                            <i class="fa fa-eye"></i>
                            <span>2000</span>
                        </div>
                        <div class="btn read" onclick="readArticle(id)">阅读详情</div>
                    </div>
                </div> -->
        </div>
    </div>
</div>
</body>
<script>

function readArticle(id) {
    window.location.href = BASE_URL + 'article/' + id;
}


    $(function(){
        'use strict';

        var $container = $('.article-list');
        var container = document.querySelector('#article-list');
        var page = 0;

        var masonry = new Masonry(container, {
            stamp: '.menu',
            itemSelector: '.box',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: true
        });

        $container.imageloader({
                    selector: '.image',
                    each: function (elm) {
                        console.log("load done");
                        console.log(elm.width + " " + elm.height);
                        $(elm).parent().css({'height':elm.height, 'width':elm.width});
                        masonry.layout();
                    }
                });

        function LoadMore() {
            $.ajax({
                type: 'POST',
                url: GET_ARTICLE_URL,
                async:false,
                data: {
                    page: page,
                    type: 'topic'
                },
                dataType: 'json',
                success: function(data) {
                    // var items = eval('(' + data + ')');
                    var items = data;

                    if(items.error != null || items.length === 0) {
                        console.log('Error');
                        return ;
                    }

                    page ++;

                    for(var i = 0; i < items.length; i++) {
                        // var items[i].content = items[i].content;

                        var article_id = items[i].content.article_id;
                        var article_title = items[i].content.sort_title;
                        var article_content = items[i].content.article_content;
                        var img = items[i].content.article_image;
                        console.log(img);
                        var like = items[i].like;
                        var read = items[i].read;


                        var box = $('<div class="box"><div class="ishadow" onclick="readArticle(' + article_id + ')"><img class="image" id="img_load_'+page+'" src="<?=base_url()?>public/img/load.gif" data-src="'+img+'" data-url="'+ img +'"/><div class="shadow"><i class="fa fa-eye"></i></div></div><p class="title">'+article_title+'</p><p class="content">'+article_content+'</p><div class="bottom clearfix"><div class="like"><i class="fa fa-heart"></i><span>'+like+'</span></div><div class="read"><i class="fa fa-eye"></i><span>'+ read +'</span></div><div class="btn read" onclick="readArticle(' + article_id + ')">阅读详情</div></div></div>');
                        $container.append(box);
                        masonry.appended(box);

                        $(box).imageloader({
                            each: function(elm){
                                masonry.layout();
                                console.log(elm.width + " " + elm.height);
                                $(elm).parent().css({'height':elm.height, 'width':elm.width});
                            },
                            callback: function (elm) {
                                console.log('loadding');
                                masonry.layout();
                            }
                        });

                        $('#img_load_'+ page).scrollLoading();
                        //Add Event
                        WindowEvent();

                        // -------------- End -------------
                    }
                }
            });
        }

        LoadMore();

        $(document).click(function(){
            console.log('click');
            LoadMore();
        });

        WindowEvent();


        function WindowEvent () {
            $(window).scroll(function(){
                // 当滚动到最底部以上100像素时， 加载新内容
                if ($(document).height() - $(this).scrollTop() - $(this).height() < 100) {
                    $(window).unbind('scroll');
                    console.log(page);
                    LoadMore();
                }
            });
        }
    });
</script>
</html>
