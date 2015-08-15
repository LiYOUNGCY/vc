<body>
    <?=$sidebar?>
    <div id="vi_container" class="container">
        <div id="shade"></div>
        <div class="content">
            <div class="publish-article">
                <form id="aform" action="<?=base_url().'article/publish/publish_article'?>" method="post">
                    <input value="" autocomplete="off" placeholder="标题" class="title" name="article_title" type="text">
                    <div class="ueditor">
                    <script type="text/plain" id="editor" name="article_content" style="width:100%;">
                        <p><br></p>
                    </script>
                    </div>
                    <div class="radio-box">
                    <p>文章分类</p>
                    <input class="radiocheck" name="article_type" id="article" type="radio" value="1" checked>
                    <label class="nofull default left" for="article">资讯</label>
                    <input class="radiocheck" name="article_type" id="topic" type="radio" value="2">
                    <label class="nofull default left" for="topic" >专题</label>
                    </div>
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
