<?php echo $navbar; ?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" style="padding:10px 0px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        文章管理
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#list" data-toggle="tab" aria-expanded="true">标签列表</a>
                            </li>
                            <li><a href="#add" data-toggle="tab" aria-expanded="false">添加标签</a>
                            </li>
                        </ul>
                        <!--表格-->
                        <div class="tab-content" style="padding:10px 0px 0px 0px;">
                            <div class="tab-pane fade active in" id="list">
                                <table id="sample-table-1" style="font-family:'Open Sans';"
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
                                        <th>标签名称</th>
                                        <th>所属分类</th>
                                        <th></th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php foreach ($tag as $k => $v) {
    ?>
                                        <tr class="selected">
                                            <td class="center">
                                                <label>
                                                    <input u="<?= $v['id'] ?>" type="checkbox" class="ace"
                                                           tag="child_check">
                                                    <span class="lbl"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <?= $v['id'] ?>
                                            </td>
                                            <td>
                                                <?= $v['name'] ?>
                                            </td>
                                            <td>
                                                <?php switch ($v['type']) {
                                                    case 1:
                                                        echo '资讯';
                                                        break;

                                                    case 2:
                                                        echo '专题';
                                                        break;
                                                }
    ?>
                                            </td>
                                            <td class="tooltip-btn">
                                                <button data-toggle="tooltip" title="编辑" effect="edit"
                                                        u="<?= $v['id'] ?>" type="button"
                                                        class="btn btn-success btn-circle"><i class="fa fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php 
} ?>
                                    </tbody>
                                </table>
                                <!-- /表格-->
                                <button id="delete" type="button" class="btn btn-outline btn-danger">删除</button>
                                <input id="modal_open" type="hidden" data-toggle="modal" data-target="#myModal"/>

                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">删除提示</h4>
                                            </div>
                                            <div class="modal-body">
                                                确认删除所勾选的标签?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" id="close_modal"
                                                        data-dismiss="modal">Close
                                                </button>
                                                <button type="button" id="delete_confirm" class="btn btn-primary">确认
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                            </div>
                            <div class="tab-pane fade" id="add">
                                <table class="table table-striped">
                                    <form id="add_form" method="post" action="<?= base_url() ?>admin/article/add_tag">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <span class="col-sm-4 col-xs-3 control-label">标签名称:</span>

                                                    <div class="col-sm-5 col-xs-8">
                                                        <input class="form-control" name="name" type="text"/>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <span class="col-sm-4 col-xs-3 control-label">所属分类:</span>

                                                    <div class="col-sm-2 col-xs-8">
                                                        <select name="type" class="form-control">
                                                            <option value="1">资讯</option>
                                                            <option value="2">专题</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </form>
                                </table>
                                <div class="panel-footer">
                                    <center>
                                        <button id="submit" type="button" class="btn btn-outline btn-primary">保存设置
                                        </button>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <!--分页-->
                        <?= $pagination ?>
                        <!-- /分页-->
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
    var DELETE_URL = ADMIN + 'article/delete_tag';
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

        //提交事件
        $('#submit').click(function () {
            $('#add_form').submit();
        });

        //删除按钮事件
        $("#delete").click(function () {
            var child = $("input[tag=child_check]:checked");
            if (child.length != 0) {
                $("#modal_open").click();
            }
            else {
                alert('请选择标签！');
                return false;
            }
        });

        //确认删除
        $("#delete_confirm").click(function () {
            var delete_str = "";
            var child = $("input[tag=child_check]:checked");
            child.each(function () {
                var uid = $(this).attr('u');
                if (uid != null && uid != undefined && uid != "") {
                    delete_str += uid + ",";
                }
            });
            if (delete_str != "") {
                delete_str = delete_str.substr(0, delete_str.length - 1);
                $.post(DELETE_URL, {aids: delete_str}, function (data) {
                    console.log(data);
                    data = eval('(' + data + ')');
                    $("#close_modal").click();
                    if (data.error != null) {
                        $(".alert-danger").append(data.error);
                        $(".alert-danger").fadeIn(1000, function () {
                            $(this).fadeOut();
                            if (data.script != "") {
                                eval(data.script);
                            }

                        });
                    }
                    else if (data.success == 0) {
                        $(".alert-success").append(data.note);
                        $(".alert-success").fadeIn(1000, function () {
                            $(this).fadeOut();
                            eval(data.script);
                        });
                    }
                });
            }
        });

        //查看
        $("button[effect=check]").click(function () {
            var aid = $(this).attr('u');
            if (aid != null && aid != "") {
                window.location.href = BASE_URL + 'article/' + aid;
            }
        });

        //编辑
        $("button[effect=edit]").click(function () {
            var id = $(this).attr('u');
            if (id != null && id != "") {
                window.location.href = BASE_URL + 'admin/article/edit/tag/' + id;
            }
        });
    });
</script>
</body>
</html>
