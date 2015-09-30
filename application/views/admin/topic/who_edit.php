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
                        专题标签管理
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <form id="form" method="post" action="<?= base_url() ?>admin/topic/update_who">
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <span class="col-sm-4 col-xs-3 control-label">ID:</span>

                                            <div class="col-sm-5 col-xs-8">
                                                <input name="id" type="hidden" value="<?= $data['id'] ?>"/>
                                                <?= $data['id'] ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <span class="col-sm-4 col-xs-3 control-label">送礼名称：</span>

                                            <div class="col-sm-5 col-xs-8">
                                                <input class="form-control" name="name" type="text"
                                                       value="<?= $data['name'] ?>"/>
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
