<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 主体 -->
    <div class="container">
        <div class="personal">
            <div class="ptitle">
                个人中心
            </div>
            <div class="pmenu">
                <ul>
                    <li>
                        <a href="<?= base_url() ?>setting">
                            <div class="icon psetting"></div>
                            <div class="mt">账户设置</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>like">
                            <div class="icon plike"></div>
                            <div class="mt">我的喜欢</div>
                        </a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0);">
                            <div class="icon pbuyed"></div>
                            <div class="mt">购买记录</div>
                        </a>
                    </li>
                    <li class="tc">
                        <a href="<?= base_url() ?>cart">
                            <div class="icon pcart"></div>
                            <div class="mt">购物车</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>msg">
                            <div class="icon pmsg"></div>
                            <div class="mt">信息</div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="transaction">
                <div class="list">
                    <?php if (empty($order)) { ?>
                        <div class="box">
                            <div class="text">您还没有购买记录呢</div>
                            <div class="go">快去选购吧！</div>
                            <div class="opt">
                                <div class="btn"><a href="<?= base_url() ?>topic">专题推荐</a></div>
                                <div class="btn"><a href="<?= base_url() ?>production">精选作品</a></div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <?php foreach ($order as $key => $o) { ?>
                            <div class="box clearfix">
                                <div class="time">
                                    <div class="icon pgoods"></div>
                                    <p><?=substr($o['create_time'], 0, 10)?></p>
                                </div>
                                <div class="glist clearfix">
                                    <?php foreach ($o['production'] as $key => $value) { ?>
                                        <div class="good">
                                            <div class="pic icon pgoodsbg">
                                                <a href="<?= base_url() ?>production/<?= $value['production_id'] ?>"
                                                   class="link">
                                                    <div
                                                        style="background: url(<?= $value['pic'] ?>);background-size:cover;background-position:50% 50%;">
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="name">
                                                <a href="<?= base_url() ?>production/<?= $value['production_id'] ?>"
                                                   class="link">
                                                    《<?= $value['production_name'] ?>》
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="total"><p>￥<?=$o['total']?></p></div>
                                </div>

                                <?php if ($o['state'] == 2) { ?>
                                    <div class="status icon psending">待发货</div>
                                <?php } else if($o['state'] == 3) { ?>
                                    <div class="logistics">
                                        <p>快递：<?=$o['transport_name']?></p>
                                        <p>地址：<?=$o['address']?></p>
                                        <div class="confirmgood btn">确认收货</div>
                                    </div>

                                    <div class="status icon psended">已发货</div>
                                <?php } else if($o['state'] == 4) {?>
                                    <div class="status icon pconform">确认收货</div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="nonebox">
                </div>
            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>
    $(function () {
//        var page = 0;
//
//        function loadmore() {
//            $.ajax({
//                type: 'POST',
//                url: GET_PERSONAL_TRANSACTION,
//                async: false,
//                data: {
//                    page: page
//                },
//                dataType: 'json',
//                success: function (data) {
//                    // var items = eval('(' + data + ')');
//                    var items = data;
//
//                    if (items.error != null || items.length === 0) {
//                        if (page == 0) {
//                            var box = '' +
//                                '<div class="box">' +
//                                '<div class="text">您还没有购买记录呢</div>' +
//                                '<div class="go">快去选购吧！</div>' +
//                                '<div class="opt">' +
//                                '<div class="btn"><a href="<?//=base_url()?>//topic">专题推荐</a></div>' +
//                                '<div class="btn"><a href="<?//=base_url()?>//production">精选作品</a></div>' +
//                                '</div></div>';
//
//                            $(".nonebox").append(box);
//                        }
//                        return;
//                    }
//
//                    page++;
//
//                    for (var i = 0; i < items.length; i++) {
//                        var time = items[i].buy_time;
//                        var goods = items[i].production;
//                        var total = items[i].amount;
//                        var status = items[i].status;
//                        var logistics = items[i].logistics;
//                        var address = items[i].address;
//                        var lid = items[i].lid;
//
//                        time = time.substr(0, 10);
//
//                        var box = '' +
//                            '<div class="box clearfix">' +
//                            '<div class="time"><div class="icon pgoods"></div><p>' + time + '</p></div>' +
//                            '<div class="glist clearfix">';
//
//                        for (var j = 0; j < goods.length; j++) {
//                            var id = goods[j].id;
//                            var name = goods[j].name;
//                            var pic = goods[j].pic;
//                            box += '' +
//                                '<div class="good">' +
//                                '<div class="pic icon pgoodsbg"><a href="<?//=base_url()?>//production/' + id + '" class="link"><div style="background: url(' + pic + ');background-size:cover;background-position:50% 50%;"></div></a></div>' +
//                                '<div class="name"><a href="<?//=base_url()?>//production/' + id + '" class="link">《' + name + '》</a></div>' +
//                                '</div>'
//                        }
//
//                        box += '' +
//                            '<div class="total"> <p>￥ ' + total + '</p></div>';
//                        if (status == 0) {
//                            box += '</div><div class="status icon psending">待发货</div></div>'
//                        } else if (status == 1) {
//                            box += '' +
//                                '<div class="logistics">' +
//                                '<p>快递：' + logistics + ' ' + lid + '</p>' +
//                                '<p>地址：' + address + '</p>' +
//                                '</div><div class="confirmgood btn">确认收货</div></div>' +
//                                '<div class="status icon psended">已发货</div></div>'
//                        } else if (status == 2) {
//                            box += '' +
//                                '<div class="logistics">' +
//                                '<p>快递：' + logistics + ' ' + lid + '</p>' +
//                                '<p>地址：' + address + '</p>' +
//                                '</div></div>' +
//                                '<div class="status icon pconform">确认收货</div></div>'
//                        }
//
//                        $(".transaction .list").append(box);
//
//                    }
//                }
//            });
//        }
//
//
//        loadmore();
    })
</script>
</html>
