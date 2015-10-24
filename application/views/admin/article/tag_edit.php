<?php
echo $navbar;
?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-primary" style="margin-top:20px;">
                    <div class="panel-heading">
                        文章管理
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <form id="form" method="post" action="<?= base_url() ?>/admin/article/update_tag">
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <span class="col-sm-4 col-xs-3 control-label">ID:</span>

                                            <div class="col-sm-5 col-xs-8">
                                                <input name="id" type="hidden" value="<?= $tag['id'] ?>"/>
                                                <?= $tag['id'] ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <span class="col-sm-4 col-xs-3 control-label">标签名称：</span>

                                            <div class="col-sm-5 col-xs-8">
                                                <input class="form-control" name="name" type="text"
                                                       value="<?= $tag['name'] ?>"/>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <span class="col-sm-4 col-xs-3 control-label">角色组:</span>

                                            <div class="col-sm-2 col-xs-8">
                                                <select name="type" class="form-control">
                                                    <?php if ($tag['type'] == 1) {
    echo '<option value="1" selected="selected">资讯</option>';
} else {
    echo '<option value="1">资讯</option>';
}

                                                    if ($tag['type'] == 2) {
                                                        echo '<option value="2" selected="selected">专题</option>';
                                                    } else {
                                                        echo '<option value="2">专题</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                </tbody>
                            </form>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <center>
                            <button id="submit" type="button" class="btn btn-outline btn-primary">保存设置</button>
                        </center>
                    </div>
                </div>

            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php
echo $foot;
?>
<script type="text/javascript">
    $(function () {
        $("#submit").click(function () {
            $("form").submit();
        });
    });
</script>
</body>
</html>
