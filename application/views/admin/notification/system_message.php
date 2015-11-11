<?php echo $navbar; ?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" style="padding:10px 0px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        消息管理
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>内容</th>
                                <th>时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($history as $key => $value) { ?>
                                <tr>
                                    <td><?= $value['message_id'] ?></td>
                                    <td><?= $value['content'] ?></td>
                                    <td><?= $value['publish_time'] ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                        <div style="margin-top: 20px;">
                            <form action="<?= base_url() . ADMINROUTE ?>notification/send_system_message" method="post">
                                <div class="form-group">
                                    <label for="message">发送系统消息</label>
                                    <input type="text" class="form-control" id="message" name="message" placeholder="系统消息">
                                </div>
                                <button type="submit" class="btn btn-default">Submit</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
    <?php echo $foot; ?>
    </body>
