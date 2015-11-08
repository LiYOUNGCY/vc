<?php echo $navbar; ?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" style="padding:10px 0px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        订单管理
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <!--表格-->
                        <table id="sample-table-1" style="margin-top: 10px;"
                               class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="center">
                                    <label>
                                        <input type="checkbox" class="ace" id="all_check">
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th>ID</th>
                                <th>订单名称</th>
                                <th>用户名</th>
                                <th>
                                    配送方式
                                </th>
                                <th>
                                    状态
                                </th>
                                <th>
                                    总价
                                </th>
                                <th>
                                    <i class="fa fa-calendar fa-fw"></i>
                                    下单时间
                                </th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($order as $k => $v) {
                                ?>
                                <tr class="selected">
                                    <td class="center">
                                        <label>
                                            <input u="<?= $v['id'] ?>" type="checkbox" class="ace" tag="child_check">
                                            <span class="lbl"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <?= $v['id'] ?>
                                    </td>
                                    <td>
                                        <?= $v['order_name'] ?>
                                    </td>
                                    <td>
                                        <?= $v['user_name'] ?>
                                    </td>
                                    <td>
                                        <?= $v['transport_name'] ?>
                                    </td>
                                    <td>
                                        <?= $v['state'] ?>
                                    </td>
                                    <td>
                                        <?= $v['total'] ?>
                                    </td>
                                    <td>
                                        <?= $v['create_time'] ?>
                                    </td>
                                    <td class="tooltip-btn">
                                        <button data-toggle="tooltip" title="查看订单详情" effect="check" u="<?= $v['id'] ?>"
                                                type="button" class="btn btn-success btn-circle"><i
                                                class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            } ?>
                            </tbody>
                        </table>
                        <!-- /表格-->
                        <input id="modal_open" type="hidden" data-toggle="modal" data-target="#myModal"/>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">删除提示</h4>
                                    </div>
                                    <div class="modal-body">
                                        确认删除所勾选的艺术品?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" id="close_modal"
                                                data-dismiss="modal">Close
                                        </button>
                                        <button type="button" id="delete_confirm" class="btn btn-primary">确认</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                    </div>
                    <!-- /.panel-body -->
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
<script type="text/javascript">
    var BASE_URL = $("#BASE_URL").val();
    var ADMIN = $("#ADMIN").val();
    var DELETE_URL = ADMIN + 'production/delete_production';
    $(function () {
        $('.tooltip-btn').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

        $("#all_check").click(function () {
            var child = $("input[tag=child_check]");
            if (child.prop('checked') == true) {
                child.prop("checked", false);
            }
            else {
                child.prop("checked", true);
            }

        });


        //查看
        $("button[effect=check]").click(function () {
            var pid = $(this).attr('u');
            if (pid != null && pid != "") {
                window.location.href = BASE_URL + 'admin/order/detail/' + pid;
            }
        });

    });
</script>
</body>
</html>
