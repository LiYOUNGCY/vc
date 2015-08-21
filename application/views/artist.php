<body>

<div class="main-wrapper">
    <?php echo $top;?>
<div class="container">
    <div class="artist-list">
<!--        <div class="artist">
            <article class="material-card Yellow">
                <h2>
                    <span>Mr Chen</span>
                </h2>
                <div class="mc-content">
                    <div class="img-container">
                        <img class="img-responsive" src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/headpic/1439898381_2.jpg">
                    </div>
                    <div class="mc-description">
                        因为长得比较帅，成为设计师也是无可厚非的
                    </div>
                </div>
                <a class="mc-btn-action">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="mc-footer">
                    <div class="btn read">See More</div>
                </div>
            </article>
        </div>-->
    </div>
</div>
</div>
<script>
    $(function() {
        var page = 0;

        var container = document.querySelector('.artist-list');

        var masonry = new Masonry(container, {
            itemSelector: '.artist',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: true
        });

        $.ajax({
            type: 'post',
            url: GET_ARTIST_LIST,
            data: {
                'page': page
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if(typeof data.error != 'undefined') {

                    return FALSE;
                }

                for(var i = 0; i < data.length; i++) {
                    var name = data[i].name;
                    var content = data[i].intro;
                    var img = data[i].pic;
                    var box = $('<div class="artist"> <article class="material-card Yellow"> <h2> <span>'+name+'</span> </h2> <div class="mc-content"> <div class="img-container"> <img class="img-responsive" src="'+img+'"> </div> <div class="mc-description">'+content+' </div> </div> <a class="mc-btn-action"> <i class="fa fa-bars"></i> </a> <div class="mc-footer"> <div class="btn read">See More</div> </div> </article> </div>');

                    // Add Event
                    box.find('.mc-btn-action').click(clickEvent);

                    $('.artist-list').append(box);
                    masonry.appended(box);
                }



            }
        });




        $('.material-card > .mc-btn-action').click(clickEvent);

        function clickEvent() {
            console.log('dd');
            var card = $(this).parent('.material-card');
            var icon = $(this).children('i');
            icon.addClass('fa-spin-fast');

            if (card.hasClass('mc-active')) {
                card.removeClass('mc-active');

                window.setTimeout(function() {
                    icon
                        .removeClass('fa-arrow-left')
                        .removeClass('fa-spin-fast')
                        .addClass('fa-bars');

                }, 800);
            } else {
                card.addClass('mc-active');

                window.setTimeout(function() {
                    icon
                        .removeClass('fa-bars')
                        .removeClass('fa-spin-fast')
                        .addClass('fa-arrow-left');

                }, 800);
            }
        }
    });
</script>

</body>
</html>