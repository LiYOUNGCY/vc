<body>
<div class="main-wrapper">
    <?php echo $top; ?>
    <div class="container">
        <div class="content edit">
            <form id="aform" class="list" action="<?= base_url() . 'article/publish/update_article' ?>" method="post">
                <input type="hidden" name="aid" value="<?=$article['id']?>">
                <input type="hidden" name="article_type" value="1">
                <div class="item line-block" style="border-style: solid;">
                    <label for="article_title">文章标题：</label>
                    <input value="<?= $article['title'] ?>" autocomplete="off" placeholder="标题" class="title" name="article_title" id="article_title" type="text">
                </div>

                <div class="item">
                    <script id="editor" name="article_content" type="text/plain" style="width:100%;height:600px;">
                        <?= $article['content'] ?>
                    </script>
                </div>

                <div class="item">
                    <label for="">文章标签：</label>
                    <input type="hidden" name="article_tag" value=" ">
                </div>

                <div class="item options">
                    <div class="save btn" id="submit">发布</div>
                </div>

            </form>
        </div>

    </div>
    <?= $footer ?>
</div>
</body>
<script src="<?= base_url() ?>public/ueditor/umeditor.config.js"></script>
<script src="<?= base_url() ?>public/ueditor/umeditor.min.js"></script>
<script src="<?= base_url() ?>public/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    $(function () {
        //实例化编辑器
        var um = UM.getEditor('editor');
        $('#submit').click(function () {
            $('#aform').submit();
        });
    });
</script>
</html>

<!--<div class="radio-box">-->
<!--    <p>文章分类</p>-->
<!--    <input class="radiocheck" name="article_tag" id="interview" value="1"-->
<!--           type="radio" --><?php //if ($article['type'] == 1) echo 'checked="true"'; ?><!-->-->
<!--    <label class="nofull default left" for="interview">访谈</label>-->
<!--    <input class="radiocheck" name="article_tag" id="exhibition" value="2"-->
<!--           type="radio" --><?php //if ($article['type'] == 2) echo 'checked="true"'; ?><!-->-->
<!--    <label class="nofull default left" for="exhibition">展览</label>-->
<!--    <input class="radiocheck" name="article_tag" id="discuss" value="3"-->
<!--           type="radio" --><?php //if ($article['type'] == 3) echo 'checked="true"'; ?><!-->-->
<!--    <label class="nofull default left" for="discuss">议论</label>-->
<!--</div>-->
