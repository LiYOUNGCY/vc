<?php echo $navbar; ?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-primary" style="margin-top:20px;">
                    <div class="panel-heading">
                        文章编辑
                    </div>
                    <div class="panel-body">
                        <form method="post" action="<?= base_url().ADMINROUTE.'article/update_article' ?>">
                            <table class="table table-striped">
                                <input name="aid" type="hidden" value="<?= $article['id'] ?>">
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <span class="col-sm-4 col-xs-3 control-label">文章标题:</span>

                                            <div class="col-sm-5 col-xs-8">
                                                <input class="form-control" name="article_title" type="text"
                                                       value="<?= $article['title'] ?>">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <span class="col-sm-4 col-xs-3 control-label">文章副标题:</span>

                                            <div class="col-sm-5 col-xs-8">
                                                <input class="form-control" name="article_subtitle" type="text"
                                                       value="<?= $article['subtitle'] ?>">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="ueditor">
                                            <script type="text/plain" id="editor" name="article_content"
                                                    style="width:100%;">
                                                    <p><?= $article['content'] ?></p>

                                            </script>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="panel-footer">
                        <center>
                            <button id="submit" type="button" class="btn btn-outline btn-primary">保存</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<?php echo $foot; ?>
<link rel='stylesheet' href="<?= base_url() ?>public/ueditor/themes/default/css/umeditor.css">
<link rel='stylesheet' href="<?= base_url() ?>public/css/ueditor.css">
<script src="<?= base_url() ?>public/ueditor/umeditor.config.js"></script>
<script src="<?= base_url() ?>public/ueditor/umeditor.min.js"></script>
<script src="<?= base_url() ?>public/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    //实例化编辑器
    var um = UM.getEditor('editor');

    $(function () {
        $('#submit').click(function () {
            $('form').submit();
        });
    });
</script>
</html> 
