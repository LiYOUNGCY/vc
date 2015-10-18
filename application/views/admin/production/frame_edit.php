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
                        艺术品管理
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <form id="form" method="post" action="<?= base_url() ?>admin/production/update_frame"
                                  enctype="multipart/form-data">
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
                                            <span class="col-sm-4 col-xs-3 control-label">裱名：</span>

                                            <div class="col-sm-5 col-xs-8">
                                                <input class="form-control" name="name" type="text"
                                                       value="<?= $data['name'] ?>"/>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <span class="col-sm-4 col-xs-3 control-label">价格(整数，单位：元)：</span>

                                            <div class="col-sm-5 col-xs-8">
                                                <input class="form-control" name="price" type="text"
                                                       value="<?= $data['price'] ?>"/>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>裱的细节图：</div>
                                        <img src="<?= $data['image'] ?>" alt=""
                                             style="max-width: 60%; margin: 1em auto; display: block;">

                                        <div class="form-group">
                                            <label for="image">重新上传裱的细节图：</label>
                                            <input type="file" id="image" name="image">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div>裱的缩略图：</div>
                                        <img src="<?= $data['thumb'] ?>" alt=""
                                             style="max-width: 60%; margin: 1em auto; display: block;">

                                        <div class="form-group">
                                            <label for="thumb">重新上传裱的缩略图：</label>
                                            <input type="file" id="thumb" name="thumb">
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
