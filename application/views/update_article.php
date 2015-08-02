<body>
    <?=$sidebar?>
    <div id="vi_container" class="container">
        <div id="shade"></div>
        <div class="content">
            <div class="publish-article">
                <form id="aform" action="<?=base_url().'article/publish/update_article'?>" method="post">
                    <input value="<?=$article['title']?>" autocomplete="off" placeholder="标题" class="title" name="article_title" type="text">
                    <input value="<?=$article['subtitle']?>" autocomplete="off" placeholder="副标题" class="subtitle" name="article_subtitle" type="text">
                    <div class="ueditor">
                    <script type="text/plain" id="editor" name="article_content" style="width:100%;">
                        <p><?=$article['content']?></p>
                    </script>
                    </div>
                    <div class="radio-box">
                    <p>文章分类</p>
                    <input class="radiocheck" name="article_tag" id="interview" type="radio" <?php if($article['type'] == 1) echo 'checked="true"'; ?>>
                    <label class="nofull default left" for="interview">访谈</label>
                    <input class="radiocheck" name="article_tag" id="exhibition" type="radio" <?php if($article['type'] == 2) echo 'checked="true"'; ?>>
                    <label class="nofull default left" for="exhibition">展览</label>
                    <input class="radiocheck" name="article_tag" id="discuss" type="radio" <?php if($article['type'] == 3) echo 'checked="true"'; ?>>
                    <label class="nofull default left" for="discuss">议论</label>
                    </div>
                    <input name="aid" type="hidden" value="<?=$article['id']?>">
                    <div class="option">
                        <div class="btn cancel">取消</div>
                        <div id="submit" class="btn publish">发布</div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div> 
</body>
<script src="<?=base_url()?>public/ueditor/umeditor.config.js"></script>
<script src="<?=base_url()?>public/ueditor/umeditor.min.js"></script>
<script src="<?=base_url()?>public/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    //实例化编辑器
    var um = UM.getEditor('editor');

    $(function(){
        $('#submit').click(function(){
            $('#aform').submit();
        });
    });
</script>
</html> 
