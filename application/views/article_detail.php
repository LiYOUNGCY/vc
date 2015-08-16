<body>
<input type="hidden" name="aid" value="<?=$article['id']?>" id="aid">
<div class="container">
    <div class="content">
        <div class="article">
            <h1 class="title"><?=$article['title'] ?></h1>

            <div class="info">字数2753 阅读113840 评论153 喜欢116</div>
            <div class="share clearfix"><!-- JiaThis Button BEGIN -->
                <div id="ckepop" class="jiathis_share">
                <span class="jiathis_txt">分享到：</span>
                    <a class="jiathis_button_tsina" title="分享到新浪微博"></a>
                    <a class="jiathis_button_weixin" title="分享到微信"></a>
                    <a class="jiathis_button_qzone" title="分享到QQ空间"></a>
                    <a class="jiathis_button_fb" title="分享到Facebook"></a>
                    <a class="jiathis_button_douban" title="分享到豆瓣"></a>
                    <a class="jiathis_button_evernote" title="分享到EverNote"></a>
                    <a class="jiathis_button_ydnote" title="分享到有道云笔记"></a>
                    <a href="http://www.jiathis.com/share?uid=1745061" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank"></a>
                <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1" charset="utf-8"></script>
                </div> <!-- JiaThis Button END -->
            </div>
            <div class="detail"><?=$article['content']?></div>
            <hr class="line"/>
            <div class="share clearfix">
                <div class="likebtn" id="vote">
                    <div class="support" id="mark-like"></div>
                    <div class="num" id="seeLike">12</div>
                </div>

                <!-- 分享按钮-->
                <!-- JiaThis Button BEGIN -->
                <div class="jiathis_style_24x24 jiathis_share" style="float: right; margin-top: 7px; height: 40px;">
                    <span class="jiathis_txt" style="font-size: 16px; height: 40px; line-height: 40px;">分享到：</span>
                    <a class="jiathis_button_tsina" title="分享到新浪微博"></a>
                    <a class="jiathis_button_weixin" title="分享到微信"></a>
                    <a class="jiathis_button_qzone" title="分享到QQ空间"></a>
                    <a class="jiathis_button_fb" title="分享到Facebook"></a>
                    <a class="jiathis_button_douban" title="分享到豆瓣"></a>
                    <a class="jiathis_button_evernote" title="分享到EverNote"></a>
                    <a class="jiathis_button_ydnote" title="分享到有道云笔记"></a>
                    <a href="http://www.jiathis.com/share"  class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank">更多</a>
                    <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1" charset="utf-8"></script>
                </div> <!-- JiaThis Button END -->
            </div>

                <div class="buddycloud">
                    <div class="stream">
                        <article class="topic">
                            <section class="opener">
                                <div class="avatar user2"></div>
                                <div class="postmeta">
                                    <span class="time"></span>
                                </div>
                                <span class="name">Vera</span><span class="location">from Campus Library</span>
                                <p>Pretend. You pretend the feelings are there, for the world, for the people around you.</p>
                                <div class="options clearfix">
                                    <div class="time">刚刚</div>
                                    <div class="reply">评论</div>
                                </div>
                                <div class="ft-comment clearfix" style="display: none;">
                                    <div class="clearfix">
                                        <textarea placeholder="post a comment..." style="float: right"></textarea>
                                    </div>
                                    <div class="btn write">评论</div>
                                    <div class="btn cancel">取消</div>
                                </div>
                            </section>
                            <div class="hidden">
                                <section class="comment">
                                    <div class="avatar user6"></div>
                                    <div class="postmeta">
                                        <span class="time">3 days</span>
                                    </div>
                                    <span class="name">Mona</span><span class="location">from Cafe Extra</span>
                                    <p>Who knows? Maybe one day they will be. I like seafood.</p>
                                </section>
                                <section class="comment">
                                    <div class="avatar user7"></div>
                                    <div class="postmeta">
                                        <span class="time">3 days</span>
                                    </div>
                                    <span class="name">Verena</span><span class="location">from Home</span>
                                    <p>Finding a needle in a haystack isn't hard when every straw is computerized. I'm really more an apartment person.</p>
                                </section>
                                <section class="comment">
                                    <div class="avatar user12"></div>
                                    <div class="postmeta">
                                        <span class="time">3 days</span>
                                    </div>
                                    <span class="name">Sebastian</span><span class="location">from Passau</span>
                                    <p>I feel like a jigsaw puzzle missing a piece. And I'm not even sure what the picture should be.</p>
                                </section>
                                <section class="comment">
                                    <div class="avatar user3"></div>
                                    <div class="postmeta">
                                        <span class="time">3 days</span>
                                    </div>
                                    <span class="name">Tom</span><span class="location">from Island</span>
                                    <p>Who knows? Maybe one day they will be. I like seafood.</p>
                                </section>
                                <section class="comment">
                                    <div class="avatar user2"></div>
                                    <div class="postmeta">
                                        <span class="time">3 days</span>
                                    </div>
                                    <span class="name">Vera</span><span class="location">from Munich</span>
                                    <p>Finding a needle in a haystack isn't hard when every straw is computerized. I'm really more an apartment person.</p>
                                </section>
                            </div><!-- /hidden -->
                            <section class="seeMore">
                                <span>See <span>5</span> More Posts</span>
                            </section>
                            <section class="comment">
                                <div class="avatar user5"></div>
                                <div class="postmeta">
                                    <span class="time">3 days</span>
                                </div>
                                <span class="name">Gero</span><span class="location">from Regensburg</span>
                                <p>I feel like a jigsaw puzzle missing a piece. And I'm not even sure what the picture should be.</p>
                            </section>
                            <section class="comment">
                                <div class="avatar user11"></div>
                                <div class="postmeta">
                                    <span class="time">3 days</span>
                                </div>
                                <span class="name">Betty</span><span class="location">from Deggendorf</span>
                                <p>I'm going to tell you something that I've never told anyone before.</p>
                            </section>
                            <section class="answer">
                                <div class="avatar user1"></div>
                                <textarea placeholder="post a comment..."></textarea>
                                <div class="controls">
                                    <div class="button small prominent">Post</div>
                                </div>
                            </section>
                        </article>
                        <article class="topic">
                            <section class="opener">
                                <div class="avatar user2"></div>
                                <div class="postmeta">
                                    <span class="time" title="5:06pm 06.06.2011">5 days</span>
                                </div>
                                <span class="name">Vera</span><span class="location">from Home</span>
                                <p>
                                    Night time - sympathize - I've been working on white lies.
                                    So I'll tell the truth - I'll give it up to you.
                                    And when the day come, it will have all been fun. We'll talk about it soon.
                                </p>
                            </section>
                            <section class="answer">
                                <div class="avatar user1"></div>
                                <textarea placeholder="post a comment..."></textarea>
                                <div class="controls">
                                    <div class="button small prominent">Post</div>
                                </div>
                            </section>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="<?=base_url()?>public/js/paperfold/modernizr.custom.01022.js"></script>
<script src="<?=base_url()?>public/js/paperfold/paperfold.js"></script>
<script>
    $(function(){
        var aid = $('#aid').val();
        $("#vote").click(function(){
            console.log(ARGEE_URL);

            $.ajax({
                type: 'POST',
                url: ARGEE_URL,
                async: false,
                data: {
                    aid: aid
                },
                dataType: 'json',
                success:function(data) {
                    console.log(data);
                    var status = data;
                    if(status.success == 0) {
                        if($('#vote').hasClass('focus')) {
                            $('#vote').attr('class','likebtn blur');
                            $('#seeLike').html(parseInt($('#seeLike').html())-1);
                        }
                        else {
                            $('#vote').attr('class','likebtn focus');
                            $('#seeLike').html(parseInt($('#seeLike').html())+1);
                        }
                    }
                    else if(status.error != null)
                    {
                        swal({
                              title: "请登录后再进行操作",
                              type: "warning",
                              showCancelButton: true,
                              confirmButtonColor: "#DD6B55",
                              confirmButtonText: "注册/登录",
                              closeOnConfirm: false
                            },
                            function(){
                              window.location.href = LOGIN_URL;
                            });
                        return false;
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
        // END vote click event

        //评论的点击事件，显示评论框
        $(".reply").click(function() {
            var self = $(this);
            self.parent().hide(100, function(){
                self.parent().next().slideDown(200)
            });

        });

        //评论中的取消事件
        $('.cancel').click(function(){
            var self = $(this).parent();
            self.slideUp(200, function(){
                self.prev().fadeIn(100);
            });
        });
    });
</script>
</html>
