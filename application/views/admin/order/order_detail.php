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
                        订单管理
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <form id="form" method="post" action="<?= base_url() ?>admin/transport/update_transport">
                                <tbody>
                                <tr>
                                    <td>

                                        <span class="col-sm-4 col-xs-3 control-label">ID:</span>

                                        <div class="col-sm-5 col-xs-8" id="order_id">
                                            <?= $data['id'] ?>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                        <span class="col-sm-4 col-xs-3 control-label">订单编号：</span>

                                        <div class="col-sm-5 col-xs-8">
                                            <?= $data['order_no'] ?>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                        <span class="col-sm-4 col-xs-3 control-label">订单名称</span>

                                        <div class="col-sm-5 col-xs-8">
                                            <?= $data['order_name'] ?>
                                        </div>

                                    </td>
                                </tr>
                                <?php
                                $total = 0;
                                foreach ($goods as $key => $value) {
                                    $total += $value['sum_price']; ?>
                                    <tr>
                                        <td>
                                            <span class="col-sm-4 col-xs-3 control-label"></span>

                                            <div class="goodslist">
                                                <div class="item">
                                                    <a href="javascript:void(0)">
                                                        <div class="pic"
                                                             style="background: url(<?= $value['pic'] ?>);background-size:cover;background-position:50% 50%;"></div>
                                                    </a>

                                                    <div class="info">
                                                        <div class="name">（ <a href=""
                                                                               class="link"><?= $value['name'] ?></a> ）
                                                        </div>
                                                        <div class="detail">
                                                            <div>装裱选择：<?= $value['frame_name'] ?>
                                                                （￥<?= $value['frame_price'] ?>）
                                                            </div>
                                                            <div>售价：￥<?= $value['price'] ?></div>
                                                            <div>总价：<span
                                                                    class="price"><?= $value['sum_price'] ?>（元）</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td>

                                        <span class="col-sm-4 col-xs-3 control-label">发票抬头：</span>

                                        <div class="col-sm-5 col-xs-8">
                                            <?php echo empty($data['issue_header']) ? '空' : $data['issue_header']; ?>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="col-sm-4 col-xs-3 control-label">配送方式：</span>

                                        <div class="col-sm-5 col-xs-8">
                                            <?= $data['transport_name'] ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="col-sm-4 col-xs-3 control-label">联系人：</span>

                                        <div class="col-sm-5 col-xs-8">
                                            <?= $data['contact'] ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="col-sm-4 col-xs-3 control-label">联系电话：</span>

                                        <div class="col-sm-5 col-xs-8">
                                            <?= $data['phone'] ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="col-sm-4 col-xs-3 control-label">地址：</span>

                                        <div class="col-sm-5 col-xs-8">
                                            <?= $data['address'] ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="col-sm-4 col-xs-3 control-label">下单时间：</span>

                                        <div class="col-sm-5 col-xs-8">
                                            <?= $data['create_time'] ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="col-sm-4 col-xs-3 control-label">运费（元）：</span>

                                        <div class="col-sm-5 col-xs-8">
                                            <?= $data['transport_price'] ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="col-sm-4 col-xs-3 control-label">手续费（元）：</span>

                                        <div class="col-sm-5 col-xs-8">
                                            <?= $data['poundage'] ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="col-sm-4 col-xs-3 control-label">合计（元）：</span>

                                        <div class="col-sm-5 col-xs-8">
                                            <?= $data['total'] ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="col-sm-4 col-xs-3 control-label">订单状态：</span>

                                        <?php if ($data['state'] == 1) { ?>
                                            <div class="col-sm-5 col-xs-8" style="color:red;">
                                                <?= $data['state_name'] ?>
                                            </div>
                                        <?php } else if ($data['state'] == 2) { ?>
                                            <div class="col-sm-5 col-xs-8" style="color:green;">
                                                <?= $data['state_name'] ?>
                                                <button id="change" type="button" class="btn btn-primary" style="margin-left: 10px;">确认并发货</button>
                                            </div>
                                        <?php } else if ($data['state'] == 3) { ?>
                                            <div class="col-sm-5 col-xs-8" style="color:blue;">
                                                <?= $data['state_name'] ?>
                                            </div>
                                        <?php } else if ($data['state'] == 4) { ?>
                                            <div class="col-sm-5 col-xs-8">
                                                <?= $data['state_name'] ?>
                                            </div>
                                        <?php } ?>

                                    </td>
                                </tr>
                                </tbody>
                            </form>
                        </table>
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
</body>
<script>
    $(function(){
        $('#change').click(function(){
            var order_id = parseInt($('#order_id').html());
            console.log(order_id);
            $.ajax({
                url: BASE_URL +'admin/order/send_goods',
                type: 'post',
                data: {
                    order_id: order_id
                },
                dataType: 'json',
                success: function(data) {
                    if(data.success == 0) {
                        alert('该订单已发货');
                        window.location.reload();
                    }
                    else if(data.error == 0) {
                        alert('错误，修改失败');
                    }
                }
            });
        });
    });
</script>
</html>
